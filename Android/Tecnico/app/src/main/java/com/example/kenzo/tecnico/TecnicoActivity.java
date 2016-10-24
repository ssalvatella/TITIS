package com.example.kenzo.tecnico;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class TecnicoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tecnico);

        Button btnTicketsTecnico = (Button) findViewById(R.id.btnTickets);
        Button btnMensajesTecnico = (Button) findViewById(R.id.btnMensajes);
        Button btnNotificacionTecnico = (Button) findViewById(R.id.btnNotificacion);

        btnTicketsTecnico.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(com.example.kenzo.tecnico.TecnicoActivity.this,
                        com.example.kenzo.tecnico.TicketsActivity.class);
                startActivity(intent);
            }
        });

        btnMensajesTecnico.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(com.example.kenzo.tecnico.TecnicoActivity.this,
                        com.example.kenzo.tecnico.MensajesActivity.class);
                startActivity(intent);
            }
        });

    }
}
