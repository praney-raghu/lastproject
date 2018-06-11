// To show Database Test Screen
function databaseTestScreen() {
    $("#paragraphHeader").html('To check Database Connection, click on <b>Test Connection</b>');
    $("#listGroupDatabase").addClass('active').removeClass('list-group-item-danger').addClass('list-group-item-info');
    $("#nextButton").hide();
    $("#testDatabaseButton").show();
}

// To show Environment(.env) file form
function showEnvironmentForm() {
    $("#originalForm").hide();
    $("#showDatabaseForm").show();
}

// To test Database Connection
function databaseTestConnection(url) {
    $.post(url,
        {
            check: "initial",
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        function (data, status, token) {
            if (data['status'] == false) {
                $("#testDatabaseButton").hide();
                $("#environmentDiv").show();

                // Assigning default values from env file to form data
                $("#host").attr("value", data['message']['host']);
                $("#db").attr("value", data['message']['db']);
                $("#username").attr("value", data['message']['username']);
                $("#pwd").attr("value", data['message']['pwd']);
            }
            else {
                $("#showDatabaseForm").hide();
                $("#testDatabaseButton").hide();
                $("#originalForm").show();
                $("#paragraphHeader").html('To add Organisation details, click on <b>Add Organisation</b>');
                $("#environmentDiv").hide();
                $("#progressBar").show();
                $("#listGroupDatabase").removeClass('active').removeClass('list-group-item-info').addClass('list-group-item-success');
                $("#listGroupOrganisation").addClass('active').removeClass('list-group-item-danger').addClass('list-group-item-info');
                $("#addOrganisationButton").show();
            }
        });
}

// Save Database Form data & check connection again
function saveDatabaseDetails(url) {
    var host = $("#host").val();
    var db = $("#db").val();
    var pwd = $("#pwd").val();
    var username = $("#username").val();

    if (host == "" || db == "" || username == "") {
        alert('Please fill the required fields.');
    }
    else {
        $.post(url,
            {
                host: host,
                db: db,
                pwd: pwd,
                username: username,
                _token: $('meta[name="csrf-token"]').attr('content')

            },
            function (data, status) {
                if (data['check'] == 1) {
                    alert(data['message']);
                    $("#showDatabaseForm").hide();
                    $("#originalForm").show();
                    $("#paragraphHeader").html('To add Organisation details, click on <b>Add Organisation</b>');
                    $("#environmentDiv").hide();
                    $("#progressBar").show();
                    $("#listGroupDatabase").removeClass('active').removeClass('list-group-item-info').addClass('list-group-item-success');
                    $("#listGroupOrganisation").addClass('active').removeClass('list-group-item-danger').addClass('list-group-item-info');
                    $("#addOrganisationButton").show();
                }
                if (data['check'] == 0) {
                    $("#showDatabaseForm").hide();
                    $("#originalForm").show();
                    $("#environmentDiv").show();
                }
            });
    }
}

// To show Add Organisation form screen
function organisationFormScreen() {
    $("#originalForm").hide();
    $("#showOrganisationForm").show();
    $("#org_domain").attr("value", window.location.host);
}

// Saving Organisation details
function saveOrganisationDetails() {
    var organisationName = $("#org_name").val();
    var organisationCode = $("#org_code").val();
    var organisationDomain = $("#org_domain").val();

    if (organisationName == "" || organisationCode == "" || organisationDomain == "") {
        alert('Please fill the required fields.');
    }
    else {
        $("#showOrganisationForm").hide();
        $("#originalForm").show();
        $("#paragraphHeader").html('To add Admin details, click on <b>Add Admin</b>');
        $('#progressbar').attr('aria-valuenow', "67").css('width', "67%");
        $("#listGroupOrganisation").removeClass('active').removeClass('list-group-item-info').addClass('list-group-item-success');
        $("#listGroupAdmin").addClass('active').removeClass('list-group-item-danger').addClass('list-group-item-info');
        $("#addOrganisationButton").hide();
        $("#addAdminButton").show();
    }
}

// To show Add Admin form screen
function adminFormScreen() {
    $("#originalForm").hide();
    $("#showAdminForm").show();
}

// Saving Admin details
function saveAdminDetails() {
    var adminName = $("#admin_name").val();
    var adminEmail = $("#admin_email").val();
    var adminPassword = $("input[name=admin_pwd]").val();
    var adminConfirmPassword = $("input[name=admin_cnf_pwd]").val();

    if (adminName == "" || adminEmail == "" || adminPassword == "" || adminConfirmPassword == "") {
        alert('Please fill the required fields.');
    }
    else {

        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (filter.test(adminEmail) == false) {
            alert('Invalid Email!');
        }
        else {
            if (adminPassword != adminConfirmPassword) {
                alert('Passwords do not match!');
            }

            else {
                $("#showAdminForm").hide();
                $("#paragraphHeader").hide();
                $("#originalForm").show();
                $("#showSeedDiv").show();
                $('#progressbar').attr('aria-valuenow', "100").css('width', "100%");
                $("#listGroupAdmin").removeClass('active').removeClass('list-group-item-info').addClass('list-group-item-success');
                $("#addAdminButton").hide();
            }
        }
    }
}

// For Seed Option Yes
function seedYes() {
    $("#showSeedDiv").hide();
    $("#seedChoiceType").show();
}

// For Seed Option No
function seedNo() {
    $("#showSeedDiv").hide();
    $("#paragraphHeader").show().html('Click on <b>Install</b> to complete Installation process.');
    $("#installationFinishButton").show();
}

// For seeding database manually
function seedManually() {
    $("#originalForm").hide();
    $("#showSeedForm").show();
    $("#manualSeedButton").val('manual');
}

// For seeding database automatically
function seedAuto() {
    $("#seedChoiceType").hide();
    $("#paragraphHeader").show().html('Click on <b>Install</b> to complete Installation process.');
    $("#installationFinishButton").show();
    $("#autoSeedButton").val('auto');
}

// Saving seed data -- if Manual option is chosen
function saveSeedDetails() {

    var subOrganisationName = $("#suborg_name").val();
    var subOrganisationCode = $("#suborg_code").val();
    var subOrganisationDomain = $("#suborg_domain").val();
    var subUserName = $("#subuser_name").val();
    var subUserEmail = $("#subuser_email").val();
    var subUserPassword = $("input[name=subuser_pwd]").val();

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (filter.test(subUserEmail) == false) {
        alert('Invalid Email!');
    }
    if (subOrganisationName == "" || subOrganisationCode == "" || subOrganisationDomain == "" || subUserName == "" || subUserEmail == "" || subUserPassword == "") {
        alert('Please fill the required fields.');
    }
    else {
        $("#showSeedForm").hide();
        $("#originalForm").show();
        $("#seedChoiceType").hide();
        $("#paragraphHeader").show().html('Click on <b>Install</b> to complete Installation process.');
        $("#installationFinishButton").show();
    }
}

// Finish Installation process
function finishInstallation(url) {

    var host = $("#host").val();
    var db = $("#db").val();
    var pwd = $("#pwd").val();
    var username = $("#username").val();
    var organisationName = $("#org_name").val();
    var organisationCode = $("#org_code").val();
    var organisationDomain = $("#org_domain").val();
    var adminName = $("#admin_name").val();
    var adminEmail = $("#admin_email").val();
    var adminPassword = $("input[name=admin_pwd]").val();
    var subOrganisationName = $("#suborg_name").val();
    var subOrganisationCode = $("#suborg_code").val();
    var subOrganisationDomain = $("#suborg_domain").val();
    var subUserName = $("#subuser_name").val();
    var subUserEmail = $("#subuser_email").val();
    var subUserPassword = $("input[name=subuser_pwd]").val();

    var choiceAuto = "";
    var choiceManual = "";
    choiceAuto = $("#autoSeedButton").val();
    choiceManual = $("#manualSeedButton").val();
    var choice = false;

    if (choiceAuto != "" || choiceManual != "")
        choice = true;

    $.post(url,
        {
            host: host,
            db: db,
            pwd: pwd,
            username: username,
            org_name: organisationName,
            org_code: organisationCode,
            org_domain: organisationDomain,
            admin_name: adminName,
            admin_email: adminEmail,
            admin_pwd: adminPassword,
            suborg_name: subOrganisationName,
            suborg_code: subOrganisationCode,
            suborg_domain: subOrganisationDomain,
            subuser_name: subUserName,
            subuser_email: subUserEmail,
            subuser_pwd: subUserPassword,
            choice: choice,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        function (data, status) {
            // Output Installation successful message
            //alert("Data: " + data['message'] + "\nStatus: " + data['status']);
            window.location.href = '/';
        });
}
