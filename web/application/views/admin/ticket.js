//jQuery UI sortable for the todo list
$(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
});

/* The todo list plugin */
$(".todo-list").todolist({
    onCheck: function (ele) {
        window.console.log("The element has been checked");
        return ele;
    },
    onUncheck: function (ele) {
        window.console.log("The element has been unchecked");
        return ele;
    }
});