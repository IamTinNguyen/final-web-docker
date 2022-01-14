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
                    $("#employee-select-box").append("<option employee-name='" + name + "' value='" + id + "'>" + name + "</option>");
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
            success: function () {}
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
                success: function () {}
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

    $("#btn-employee-submit").click(function (e) {
        var contentSubmitField = $("#content_employee_submit");
        var wrapperContentSubmitField = $("#content_employee_submit_wrapper");
        var fileSubmitField = $("#file_employee_submit");
        var wrapperFileSubmitField = $("#file_employee_submit_wrapper");
        var tmp1 = true;
        if (contentSubmitField.val() == '') {
            contentSubmitField.addClass('is-invalid');

            $(this).removeAttr('data-toggle');
            if ($(".invalid-feedback").length == 0) {
                wrapperContentSubmitField.append('<div class="invalid-feedback">Vui lòng nhập phản hồi trước khi submit nhiệm vụ này!</div>');
            }
            var tmp1 = false;
            return e.preventDefault();
        } else {
            contentSubmitField.removeClass('is-invalid');
            $(this).attr('data-toggle', 'modal');
        }
        console.log($(".invalid-feedback").length);
        if (fileSubmitField.val() == '') {
            fileSubmitField.addClass('is-invalid');

            $(this).removeAttr('data-toggle');
            if ($(".error-file").length == 0) {
                wrapperFileSubmitField.append('<div class = "error-file" style = "color: #f33a58;">Vui lòng chọn file trước khi submit form!</div>');

            }
            return e.preventDefault();
        } else {
            fileSubmitField.removeClass('is-invalid');
            $(this).attr('data-toggle', 'modal');
        }
    })

    $("#employee").submit(e => {
        let username = $("#username").val()
        let username_list = []
        for (var i = 0; i < employee.length; i++) {
            username_list.push(employee[i].username);
        }
        if ($("#username").prop('readonly') == false) {
            if (username.length < 6) {
                e.preventDefault();
                displayError("Tên người dùng quá ngắn, vui lòng nhập lại")
            }
            if (username_list.includes(username)) {
                e.preventDefault();
                displayError("Tên người dùng đã tồn tại, xin chọn tên khác")
            }
        }
        $("#name_department").removeAttr('disabled')
    })

    function displayError(message) {
        $("#errorMessage").html(message)
        $("#errorMessage").show()
    }

    $("#btn-add").click(function () {
        $("#absence_letter").removeAttr('hidden')
        $("#letter_list").attr('hidden', true)
        $("#btn-add").attr('hidden', true)
        $("#header").removeAttr('hidden')
        $("#day_off_default").attr('hidden', true)
        $("#day_off_used").attr('hidden', true)
        $("#day_off_left").attr('hidden', true)
    })

    $("#btn-back").click(function () {
        $("#absence_letter").attr('hidden', true)
        $("#letter_list").removeAttr('hidden')
        $("#btn-add").removeAttr('hidden')
        $("#header").removeAttr('hidden')
        $("#day_off_default").removeAttr('hidden')
        $("#day_off_used").removeAttr('hidden')
        $("#day_off_left").removeAttr('hidden')
    })

    $("#add-task-btn").click(function(e) {
        var idEmployeeWrapper = $("#employee-slt-box-wrapper");
        var idEmployeeField = $("#employee-slt-box");
        var is_invalid = false;

        if (idEmployeeField.val() == 'Chọn nhân viên sẽ nhận nhiệm vụ') {
            idEmployeeField.addClass('is-invalid');
            if ($("#employee-slt-box-msg").length == 0) {
                idEmployeeWrapper.append('<div id="employee-slt-box-msg" class="invalid-feedback">Vui lòng chọn một nhân viên cụ thể!</div>');
            }
            e.preventDefault();
        }
    })

    $("#appoint-manager-btn").click(function() {
        var departmentField = $("#department-select-box");
        var departmentWrapper = $("#department-name-wrapper");
        var employeeField = $("#employee-select-box");

        if (departmentField.val() == "Chọn tên phòng ban") {
            departmentField.addClass('is-invalid');
            if ($("#employee-msg").length == 0) {
                departmentWrapper.append('<div id="employee-msg" class="invalid-feedback">Vui lòng chọn tên phòng ban!</div>');
            }
        } else {
            departmentField.children().each(function(departmentOptionIndex, departmentOptionValue) {
                if (departmentOptionValue.getAttribute('value') == departmentField.val()){
                    const selectedDepartmentName = departmentOptionValue.getAttribute("department-name");
                    $("#confirm-appoint-manager .modal-dialog .modal-body").attr("department-name", selectedDepartmentName);
                }
            })

            employeeField.children().each(function(employeeOptionIndex, employeeOptionValue) {
                if (employeeOptionValue.getAttribute('value') == employeeField.val()){
                    const selectedEmployeeName = employeeOptionValue.getAttribute("employee-name");
                    $("#confirm-appoint-manager .modal-dialog .modal-body").attr("employee-name", selectedEmployeeName);
                }
            })

            $(this).attr("data-toggle","modal");

            var confirmMessageBox = $("#confirm-appoint-manager .modal-dialog .modal-body");
            confirmMessageBox.html("Bạn có chắc rằng muốn bổ nhiệm <strong>"+ confirmMessageBox.attr("employee-name") + " </strong>làm trưởng phòng của<strong> " + confirmMessageBox.attr("department-name") + " </strong>không?");
        }
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
            document.getElementById('size').innerHTML = '';
            btnEmployeeSubmit.disabled = false;
        }
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
            document.getElementById('size2').innerHTML = '';
            btnEmployeeSubmit.disabled = false;

        }
        console.log(fileTotalSize);
    }
}
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
    });
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
let sidebarSpace = document.querySelector("#sidebar_space");
let contentSpace = document.querySelector("#content_space");

console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {

    sidebar.classList.toggle("close");
});