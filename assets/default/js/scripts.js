"use strict";

$(document).ready(function () {

    // Correct the height of the content area
    var documentHeight = $('html').outerHeight(),
        navbarHeight = $('.navbar').outerHeight(),
        headerbarHeight = $('#headerbar').outerHeight(),
        contentHeight = documentHeight - navbarHeight - headerbarHeight;
    if ($('#content').outerHeight() < contentHeight) {
        $('#content').outerHeight(contentHeight);
    }

    // Dropdown Datepicker fix
    $('html').click(function () {
        $('.dropdown-menu:visible').not('.datepicker').removeAttr('style');
    });

    // Handle click event for Email Template Tags insertion
    // Example Usage
    // <a href="#" class="text-tag" data-tag="{{{client_name}}}">Client Name</a>
    var lastTaggableClicked;
    $('.text-tag').bind('click', function () {
        var templateTag = this.getAttribute("data-tag");
        insertAtCaret(lastTaggableClicked.id, templateTag);
        return false;
    });

    // Keep track of the last "taggable" input/textarea
    $('.taggable').on('focus', function () {
        lastTaggableClicked = this;
    });
});


// Insert text into textarea at Caret Position
function insertAtCaret(areaId, text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (document.selection ? "ie" : false));
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart('character', -txtarea.value.length);
        strPos = range.text.length;
    } else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0, strPos);
    var back = (txtarea.value).substring(strPos, txtarea.value.length);
    txtarea.value = front + text + back;
    strPos = strPos + text.length;
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart('character', -txtarea.value.length);
        range.moveStart('character', strPos);
        range.moveEnd('character', 0);
        range.select();
    } else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}

// takes mdl_email_template row as JSON, array with names to use in form fields.
function inject_email_template(template_fields, email_template) {
    $.each(email_template, function (key, val) {
        // remove prefix from key
        key = key.replace("email_template_", "");
        // if key is in template_fields, apply value to form field
        if (val && template_fields.indexOf(key) > -1) {
            $("#" + key).val(val);
        }
    });
}