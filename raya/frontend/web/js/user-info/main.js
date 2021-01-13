$(document).ready(function () {
    $('.date-picker-only').persianDatepicker({
        format: 'YYYY/MM/DD',
        autoClose: true,
        persianDigit: true,
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });
});
