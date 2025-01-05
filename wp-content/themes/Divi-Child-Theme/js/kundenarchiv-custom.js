jQuery(document).ready(function ($) {
    updateBereichChekedList();
    $('input[name="bereich[]"]').on('change', function (e) {
        updateBereichChekedList();
    });

    function updateBereichChekedList() { // function that updates the checked list in Bereich label
        let checked_values = $('input[name="bereich[]"]:checked');
        if (checked_values.length > 0) {
            let check_title = $(checked_values[0]).siblings(".check-item").html();
            if (checked_values.length > 1) { // if the checked list is greater than 1
                let append_text = parseInt(checked_values.length) - 1;
                check_title += "(+ " + append_text + ")";
                $(".bereich-checklist .check-title").html(check_title);
            } else {// if the checked item is exactly one
                $(".bereich-checklist .check-title").html(check_title);
            }
        } else {
            $(".bereich-checklist .check-title").html("");
        }
    }

    frontFormInteractive();

    function frontFormInteractive() {
        $('.custom-date-filter .label-input-wrapper .check-header').on('click', function () {
            $(this).next().slideToggle();
            $(this).toggleClass('open-check-list');
        });

        $('.filtered-data-table .table-content .last-closer svg').on('click', function () {
            $(this).parent().parent('.last-closer').toggleClass('open-full-cont');
            $('.filtered-data-table .table-content .last-closer svg').not(this).parent().parent('.last-closer').removeClass('open-full-cont');
        });

        $('.mobile-filter-table .table-content .toggler-opener').on('click', function () {
            $(this).closest('.table-content').next().slideToggle();
            $(this).toggleClass('opened-toggler');
            $(this).parent().parent().toggleClass('background-active-cls');
            $('.mobile-filter-table .table-content .toggler-opener').not(this).closest('.table-content').next().slideUp();
            $('.mobile-filter-table .table-content .toggler-opener').not(this).removeClass('opened-toggler');
            $('.mobile-filter-table .table-content .toggler-opener').not(this).parent().parent().removeClass('background-active-cls');
        });

        $('.mb-filter-toggler .svg-toggler').on('click', function () {
            $(this).parent().next('.custom-date-filter').slideToggle();
            $(this).parent().toggleClass('opened-mb-filter');
        });

        $('.custom-date-filter .letter-filter .letter-filter-head .select-drop').on('click', function () {
            $(this).parent().next().slideToggle();
            $(this).parent().toggleClass('open-letter-filter-list');
        });
    }

    $(window).on('load resize', function () {

        $('.filtered-data-table .table .table-content .table-row').each(function () {
            var boxHEight = $(this).find('.last-closer').outerHeight(true);
            console.log(boxHEight);
            $(this).find('.last-closer').removeClass('one-line');
            if ($(this).find('.last-closer .text-inner').outerHeight(true) < 23) {
                $(this).find('.last-closer').addClass('one-line');
            }
        });
    });

    $('.table-filter-form').submit(function (e) { // validation of the search form
        // your code here
        let suche = $("input[name='suche']").val();
        let suche_in = $('input[name="suchen_in[]"]:checked');
        if (suche.length > 0 && suche_in.length == 0) {
            e.preventDefault();
            alert("Bitte wählen Sie eine der 3 Suchkategorien aus und versuchen Sie es erneut.");
        }
        if (suche.length == 0 && suche_in.length > 0) {
            e.preventDefault();
            alert("Please enter the Suche text");
        }
    });

    $(".clear-btn").on("click", function (e) {
        e.preventDefault();
        $("form.kundenarchiv-filter-form input[name='suche']").val("");
        $("form.kundenarchiv-filter-form input[name='from']").val("");
        $("form.kundenarchiv-filter-form input[name='until']").val("");
        $("form.kundenarchiv-filter-form input[name='suchen_in[]']").prop('checked', false);
        $("form.kundenarchiv-filter-form input[name='bereich[]']").prop('checked', false);
        $("form.kundenarchiv-filter-form input[name='starts_with']").removeAttr("checked");
        $(".bereich-checklist .check-title").html("");

        $('.clear-btn').removeClass('clear-visible');
    });

    $("form.kundenarchiv-filter-form input").on("keyup change", function (e) {
        e.preventDefault();

        if (
            ('text' === $(this).attr('type') && $(this).val()) ||
            ('search' === $(this).attr('type') && $(this).val()) ||
            $('input').is(':checked')
        ) {
            $('.clear-btn').addClass('clear-visible');
        } else {
            $('.clear-btn').removeClass('clear-visible');
        }

    });

});
