#!/usr/bin/env python
# -*- coding: utf-8 -*-

import shutil
from tempfile import mkstemp
from shutil import move
from os import remove, close
import paramiko, base64

def reemplazar(file_path, pattern, subst):
    # Crea un fichero temporal
    fh, abs_path = mkstemp()
    with open(abs_path,'w') as new_file:
        with open(file_path) as old_file:
            for line in old_file:
                new_file.write(line.replace(pattern, subst))
    close(fh)
    # Elimina el fichero original
    remove(file_path)
    # Mueve el nuevo fichero
    move(abs_path, file_path)

def print_totals(transferred, toBeTransferred):
    print "Transferido: {0}\tTotal: {1}".format(transferred, toBeTransferred)


print 'Copiando carpeta web'
shutil.copytree('web', 'web_copia')

shutil.rmtree('web_copia/nbproject')

print 'Modificando .htaccess'
reemplazar('web_copia/.htaccess', '# RewriteBase /titis/', ' RewriteBase /titis/')

print 'Modificando config.php'
reemplazar('web_copia/application/config/config.php', "$config['base_url'] = 'http://titis.dev/';", "$config['base_url'] = 'http://155.210.68.155/titis/';")

print 'Creando titis.zip'
shutil.make_archive('titis', 'zip', 'web_copia')

print 'Eliminando web_copia'
shutil.rmtree('web_copia')

print 'Conectandose al servidor'
ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('155.210.68.155', username='root', password='sistemasweb')
sftp = ssh.open_sftp()

print 'Eliminando la antigua carpeta titis'
stdin, stdout, stderr = ssh.exec_command('rm -R /var/www/html/titis')
exit_status = stdout.channel.recv_exit_status() # Llamada bloqueante hasta que se ejecuta el comando

print 'Creando la carpeta titis'
stdin, stdout, stderr = ssh.exec_command('mkdir /var/www/html/titis')
exit_status = stdout.channel.recv_exit_status()   

print 'Subiendo titis.zip'
sftp.put('titis.zip', '/var/www/html/titis/titis.zip', callback=print_totals)

print 'Extrayendo titis.zip'
stdin, stdout, stderr = ssh.exec_command('unzip /var/www/html/titis/titis.zip -d /var/www/html/titis/')
exit_status = stdout.channel.recv_exit_status()   

print 'Eliminando titis.zip en el servidor'
stdin, stdout, stderr = ssh.exec_command('rm /var/www/html/titis/titis.zip')
exit_status = stdout.channel.recv_exit_status() 
'''
stdin, stdout, stderr = ssh.exec_command('ls /var/www/html/titis')
for line in stdout:
    print '... ' + line.strip('\n')
'''
print 'Cerrando conexión con el servidor'
sftp.close()
ssh.close()

print 'Eliminando titis.zip'
remove('titis.zip')