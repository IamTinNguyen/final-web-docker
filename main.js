$(document).ready(function () {
    $("#department-select-box").change(function () {
        var departmentId = $(this).val();
        $.ajax({
            url: 'department/get_employees_of_current_department.php',
            type: 'GET',
            data: {
                id_department: departmentId
            },
            dataType: 'json',
            success: function (response) {
                $("#employee-select-box").empty();
                for (var i = 0; i < response.data.length; i++) {
                    var id = response.data[i]['id_employee'];
                    var name = response.data[i]['full_name'];
                    $("#employee-select-box").append("<option value='" + id + "'>" + name + "</option>");
                }
            }
        })
    })

    $("#delete-btn").click(function () {
        var id_task = $(this).attr('data-id');
        $.ajax({
            url: 'task_management/cancel_task.php',
            type: 'GET',
            data: {
                id_task: id_task
            },
            dataType: 'json',
            success: function () { }
        })
        location.href = "?type=task_management&action=detail&id_task=" + id_task;
    })

    $(".edit-task-btn").click(function (e) {
        location.href = "?type=task_management&action=add&id_task=" + $(this).data("id");
    })

    $("#approve-task-btn").click(function (e) {
        var rateField = $("#rate-select-box");
        var wrapperRateField = $("#wrapper-rate-field");
        var rate = rateField.val();

        if (rateField.val() == 0) {
            rateField.addClass('is-invalid');

            if ($(".invalid-feedback").length == 0) {
                wrapperRateField.append('<div class="invalid-feedback">Vui lòng chọn mức độ đánh giá trước khi chấp thuận nhiệm vụ này!</div>');
            }
        } else {
            var id_task = $(this).attr('data-id');
            $.ajax({
                url: 'task_management/approve_task.php',
                type: 'GET',
                data: {
                    id_task: id_task,
                    rate: rate,
                },
                dataType: 'json',
                success: function () { }
            })
            location.href = "?type=task_management&action=detail&id_task=" + id_task;
        }
    })

    $("#reject-task-btn").click(function () {
        var feedbackField = $("#feedback");
        var wrapperFeedbackField = $("#wrapper-feedback");

        if (feedbackField.val() == '') {
            $(this).removeAttr('data-toggle');
            feedbackField.addClass('is-invalid');

            if ($(".invalid-feedback").length == 0) {
                wrapperFeedbackField.append('<div class="invalid-feedback">Vui lòng nhập phản hồi trước khi bác bỏ nhiệm vụ này!</div>');
            }

        } else {
            feedbackField.removeClass('is-invalid');
            $(this).attr('data-toggle', 'modal');
        }
    })
    $("#form_employee_submit").submit(function () {
        alert("Bạn vừa submit thành công");
    })
    $("#btn-employee-submit").click(function (e) {
        var contentSubmitField = $("#content_employee_submit");
        var wrapperContentSubmitField = $("#content_employee_submit_wrapper");
        var fileSubmitField = $("#file_employee_submit");
        var wrapperFileSubmitField = $("#file_employee_submit_wrapper");
        var tmp1 = true;
        if (contentSubmitField.val() == '') {
            contentSubmitField.addClass('is-invalid');

            if ($(".invalid-feedback").length == 0) {
                wrapperContentSubmitField.append('<div class="invalid-feedback">Vui lòng nhập phản hồi trước khi bác bỏ nhiệm vụ này!</div>');
            }
            var tmp1 = false;
            return e.preventDefault();
        } else {
            contentSubmitField.removeClass('is-invalid');
        }
        console.log($(".invalid-feedback").length);
        if (fileSubmitField.val() == '') {
            fileSubmitField.addClass('is-invalid');
            if ($(".error-file").length == 0) {
                wrapperFileSubmitField.append('<div class = "error-file" style = "color: #f33a58;">Vui lòng chọn file trước khi submit form!</div>');

            }



            return e.preventDefault();
        } else {
            fileSubmitField.removeClass('is-invalid');
        }
    })
    $("#employee").submit(e => {
        let username = $("#username").val()
        let username_list = []
        for (var i = 0; i < employee.length; i++) {
            username_list.push(employee[i].username);
        }
        if (username.length < 6) {
            e.preventDefault();
            displayError("Username too short")
        }
        if (username_list.includes(username)) {
            e.preventDefault();
            displayError("Username da ton tai")
        }
    })

    function displayError(message) {
        $("#errorMessage").html(message)
        $("#errorMessage").show()
    }

    $("#btn-add").click(function () {
        $("#absence_letter").removeAttr('hidden')
        $("#letter_list").attr('hidden', true)
        $("#btn-add").attr('hidden', true)
        $("#day_off").attr('hidden', true)
    })

    $("#btn-back").click(function () {
        $("#absence_letter").attr('hidden', true)
        $("#letter_list").removeAttr('hidden')
        $("#btn-add").removeAttr('hidden')
        $("#day_off").removeAttr('hidden')
    })




})

Filevalidation = () => {
    const fi = document.getElementById('file_employee_submit');
    const formElementEmployee = document.getElementById('form_employee_submit');
    const btnEmployeeSubmit = document.getElementById('btn-employee-submit');

    // Check if any file is selected.
    if (fi.files.length > 0) {
        var fileTotalSize = 0;
        for (let i = 0; i <= fi.files.length - 1; i++) {

            let fsize = fi.files.item(i).size;
            let file = Math.round((fsize / 1024));
            fileTotalSize = fileTotalSize + file;
            console.log(fileTotalSize);
            // The size of the file.

        }
        if (fileTotalSize >= 5120) {
            document.getElementById('size').innerHTML = 'File quá lớn, vui lòng chọn file nhỏ hơn 5Mb!';
            btnEmployeeSubmit.disabled = true;

        } else {
            btnEmployeeSubmit.disabled = false;

        }
        console.log(fileTotalSize);
    }
}

FilevalidationLetter = () => {
    const fi = document.getElementById('file_letter_submit');
    const btnEmployeeSubmit = document.getElementById('btn_letter_submit');

    // Check if any file is selected.
    if (fi.files.length > 0) {
        var fileTotalSize = 0;
        for (let i = 0; i <= fi.files.length - 1; i++) {

            let fsize = fi.files.item(i).size;
            let file = Math.round((fsize / 1024));
            fileTotalSize = fileTotalSize + file;
            console.log(fileTotalSize);
            // The size of the file.

        }
        if (fileTotalSize >= 5120) {
            document.getElementById('size2').innerHTML = 'File quá lớn, vui lòng chọn file nhỏ hơn 5Mb!';
            btnEmployeeSubmit.disabled = true;

        } else {
            btnEmployeeSubmit.disabled = false;

        }
        console.log(fileTotalSize);
    }
}