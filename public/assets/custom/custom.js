jQuery(document).ready(function () {
    const ROOT_DIR = "/CRM/dashboard";

    $("form").submit(function () {
        $(this).submit(function () {
            return false;
        });
        return true;
    });

    jQuery("#accordion-2").on("hidden.bs.collapse", function (e) {
        jQuery(e.target)
            .prev(".card-header")
            .find(".more-less")
            .toggleClass("mdi-plus mdi-minus");
    });
    $("#accordion-2").on("shown.bs.collapse", function (e) {
        jQuery(e.target)
            .prev(".card-header")
            .find(".more-less")
            .toggleClass("mdi-plus mdi-minus");
    });

    // get total numbers
    var dollar = 0;
    var afg = 0;
    jQuery(".price").each(function () {
        if ($.trim($("span:not(:first)", this).text()) == "Dollar") {
            dollar += eval($.trim($("span:not(:last)", this).text()));
        } else if ($.trim($("span:not(:first)", this).text()) == "AFG") {
            afg += eval($.trim($("span:not(:last)", this).text()));
        }
    });

    var discount = 0;
    jQuery(".discount").each(function () {
        if ($.trim($("span:not(:first)", this).text()) == "Dollar") {
            discount = eval($.trim($("span:not(:last)", this).text()));
            dollar -= discount;
        } else if ($.trim($("span:not(:first)", this).text()) == "AFG") {
            discount = eval($.trim($("span:not(:last)", this).text()));
            afg -= discount;
        }
    });

    $(".afg").text(afg + " AFG");
    $(".dollar").text(dollar + " Dollar");

    // Owl carousel in single pages

    var owl = jQuery(".owl-1");
    owl.owlCarousel({
        loop: false,
        touchDrag: false,
        mouseDrag: false,
        margin: 0,
        nav: false,
        dots: false,
        items: 1,
        smartSpeed: 1000,
        autoplay: false,
        navText: [
            '<span class="icon-keyboard_arrow_left">',
            '<span class="icon-keyboard_arrow_right">',
        ],
    });

    var carousel_nav_a = $(".carousel-nav a");

    carousel_nav_a.each(function (slide_index) {
        var $this = $(this);
        $this.attr("data-num", slide_index);
        $this.click(function (e) {
            owl.trigger("to.owl.carousel", [slide_index, 1500]);
            e.preventDefault();
        });
    });

    owl.on("changed.owl.carousel", function (event) {
        carousel_nav_a.removeClass("active");
        $(".carousel-nav a[data-num=" + event.item.index + "]").addClass(
            "active"
        );
    });

    // Phone number validation

    $("#phone1 , #phone2").on("keyup", function () {
        var number = $(this).val();

        var reg = /^\+93((77|78|79|70|73|74|72|76)\d{7})$/;
        var reg2 = /^\b07(7|8|3|2|0|6|4|9)\d{7}$/;
        var reg3 = /^\b0093((77|78|79|70|73|74|72|76)\d{7})$/;

        if (reg.test(number)) {
            $(this).css("border-color", "green");
            $(":submit").removeAttr("disabled");
        } else if (reg2.test(number)) {
            $(this).css("border-color", "green");
            $(":submit").removeAttr("disabled");
        } else if (reg3.test(number)) {
            $(this).css("border-color", "green");
            $(":submit").removeAttr("disabled");
        } else if (number == "") {
            $(this).css("border-color", "#ced4da");
            $(":submit").removeAttr("disabled");
        } else {
            $(this).css("border-color", "red");
            $(":submit").attr("disabled", true);
        }
    });

    /*
     *   Checking the equipment types
     */

    jQuery("#equi_type").on("change", function () {
        var type = jQuery(this).val();
        if (type == "sell") {
            jQuery("#leased_type").attr("disabled", "disabled");
            jQuery("#receiver_price")
                .removeAttr("disabled")
                .attr("required", "required");

            jQuery("#receiver_type").attr("required", "required");
            jQuery("label[for='receiver_type']").addClass("required");
            jQuery("label[for='receiver_price']").addClass("required");

            jQuery("#leased_type").removeAttr("required");
            jQuery("label[for='leased_type']").removeClass("required");
        } else if (type == "leased") {
            jQuery("#receiver_price").removeAttr("disabled");
            jQuery("#leased_type").removeAttr("disabled");

            jQuery("#leased_type").attr("required", "required");
            jQuery("label[for='leased_type']").addClass("required");
        } else if (type == "own") {
            jQuery("#leased_type").attr("disabled", "disabled");
            jQuery("#receiver_price").attr("disabled", "disabled");
            jQuery("#receiver_type").removeAttr("required");
            jQuery("label[for='receiver_type']").removeClass("required");
            jQuery("label[for='receiver_price']").removeClass("required");

            jQuery("#leased_type").removeAttr("required");
            jQuery("label[for='leased_type']").removeClass("required");
        } else {
            jQuery("#leased_type").removeAttr("disabled");
            jQuery("#receiver_price").removeAttr("disabled");

            jQuery("#receiver_type").removeAttr("required");
            jQuery("label[for='receiver_type']").removeClass("required");
            jQuery("label[for='receiver_price']").removeClass("required");

            jQuery("#leased_type").removeAttr("required");
            jQuery("label[for='leased_type']").removeClass("required");
        }
    });

    jQuery("#leased_type").on("change", function () {
        var type = jQuery(this).val();
        if (type == "full") {
            jQuery("#receiver_price")
                .attr("disabled", "disabled")
                .removeAttr("required");
            jQuery("label[for='receiver_price']").removeClass("required");

            jQuery("#receiver_type").removeAttr("required");
            jQuery("label[for='receiver_type']").removeClass("required");
        } else {
            jQuery("#receiver_price")
                .removeAttr("disabled")
                .attr("required", "required");
            jQuery("label[for='receiver_price']").addClass("required");

            jQuery("#receiver_type").attr("required", "required");
            jQuery("label[for='receiver_type']").addClass("required");
        }
    });

    // // updating the package price by inserting discount
    // $('#package_price').off().on('keyup',function(){
    //     $('#package_price_hidden').val($(this).val());
    // });

    // $('#discount').off().on('keyup',function(){
    //     var price = $('#package_price_hidden').val();
    //     $('#package_price').val(price - $(this).val());
    // });

    /*
     *   Additional Input fields
     *   resellers input toggling
     */

    if (!$("#commission").val() && !$("#commission").prop("required")) {
        $("#commission").parent().parent().css("display", "block");
        $("#commission_percent").parent().parent().css("display", "block");
        $("#resellerCheckbox").prop("checked", false);
    } else {
        $("#commission").parent().parent().css("display", "block");
        $("#commission_percent").parent().parent().css("display", "block");
        $("#resellerCheckbox").prop("checked", true);
    }

    $("#resellerCheckbox").on("change", function (e) {
        e.preventDefault();

        if ($(this).is(":checked")) {
            $("#commission").parent().parent().css("display", "block");
            $("#commission_percent").parent().parent().css("display", "block");
            $("#commission, #commission_percent")
                .parent()
                .parent()
                .css("background-color", "#eee");
        } else {
            $("#commission").parent().parent().css("display", "block");
            $("#commission_percent").parent().parent().css("display", "block");
            $("#commission, #commission_percent")
                .parent()
                .parent()
                .css("background-color", "unset");
        }
    });

    $(document).on("change", "#discount_period_currency", function () {
        if ($(this).val() == "Permanent") {
            $("#discount_period").val(1);
        }
    });

    // Discount input toggling
    if (!$("#discount").val() == "" || $("#discount").val() == 0) {
        $("#discount").parent().parent().css("display", "block");
        $("#discount_period").parent().parent().css("display", "block");
        $("#discount_reason").parent().parent().css("display", "block");
        $("#discountCheckbox").prop("checked", false);
    } else {
        $("#discount").parent().parent().css("display", "none");
        $("#discount_period").parent().parent().css("display", "none");
        $("#discount_reason").parent().parent().css("display", "none");
        $("#discountCheckbox").prop("checked", true);
    }

    $("#discountCheckbox").on("change", function (e) {
        e.preventDefault();

        if ($(this).is(":checked")) {
            $("#discount").parent().parent().css("display", "block");
            $("#discount").parent().parent().css("background-color", "#eee");

            $("#discount_period").parent().parent().css("display", "block");
            $("#discount_period")
                .parent()
                .parent()
                .css("background-color", "#eee");

            $("#discount_reason").parent().parent().css("display", "block");
            $("#discount_reason")
                .parent()
                .parent()
                .css("background-color", "#eee");
        } else {
            $("#discount").parent().parent().css("display", "none");
            $("#discount").parent().parent().css("background-color", "unset");

            $("#discount_period").parent().parent().css("display", "none");
            $("#discount_period")
                .parent()
                .parent()
                .css("background-color", "unset");

            $("#discount_reason").parent().parent().css("display", "none");
            $("#discount_reason")
                .parent()
                .parent()
                .css("background-color", "unset");
        }
    });

    // IP input toggling
    if (!$("#public_ip").val()) {
        $("#public_ip").parent().parent().css("display", "none");
        $("#ip_price").parent().parent().css("display", "none");
        $("#ipCheckbox").prop("checked", false);
    } else {
        $("#public_ip").parent().parent().css("display", "block");
        $("#ip_price").parent().parent().css("display", "block");
        $("#ipCheckbox").prop("checked", true);
    }

    $("#ipCheckbox").on("change", function (e) {
        e.preventDefault();

        if ($(this).is(":checked")) {
            $("#public_ip").parent().parent().css("display", "block");
            $("#ip_price").parent().parent().css("display", "block");
            $("#public_ip, #ip_price")
                .parent()
                .parent()
                .css("background-color", "#eee");
        } else {
            $("#public_ip").parent().parent().css("display", "none");
            $("#ip_price").parent().parent().css("display", "none");
            $("#public_ip, #ip_price")
                .parent()
                .parent()
                .css("background-color", "unset");
        }
    });

    // Additional input toggling
    if (!$("#additional_charge").val()) {
        $("#additional_charge").parent().parent().css("display", "none");
        $("#additional_charge_price").parent().parent().css("display", "none");
        $("#additionalCheckbox").prop("checked", false);
    } else {
        $("#additional_charge").parent().parent().css("display", "block");
        $("#additional_charge_price").parent().parent().css("display", "block");
        $("#additionalCheckbox").prop("checked", true);
    }

    $("#additionalCheckbox").on("change", function (e) {
        e.preventDefault();

        if ($(this).is(":checked")) {
            $("#additional_charge").parent().parent().css("display", "block");
            $("#additional_charge_price")
                .parent()
                .parent()
                .css("display", "block");
            $("#additional_charge, #additional_charge_price")
                .parent()
                .parent()
                .css("background-color", "#eee");
        } else {
            $("#additional_charge").parent().parent().css("display", "none");
            $("#additional_charge_price")
                .parent()
                .parent()
                .css("display", "none");
            $("#additional_charge, #additional_charge_price")
                .parent()
                .parent()
                .css("background-color", "unset");
        }
    });

    // format mac address

    var macAddress = document.getElementById("reciever_mac");

    function formatMAC(e) {
        var r = /([a-f0-9]{2})([a-f0-9]{2})/i,
            str = e.target.value.replace(/[^a-f0-9]/gi, "");

        while (r.test(str)) {
            str = str.replace(r, "$1" + ":" + "$2");
        }
        e.target.value = str.slice(0, 17);
    }

    if (macAddress) {
        macAddress.addEventListener("keyup", formatMAC, false);
    }

    // lats and longs

    $("#latitiude").on("keyup", function () {
        if (!$(this).val() == "") {
            if ($(this).val() < -90 || $(this).val() > 90) {
                alert("Latitude must be between -90 and 90 degrees inclusive.");
            }
        }
    });

    $("#longitude").on("keyup", function () {
        if (!$(this).val() == "") {
            if ($(this).val() < -180 || $(this).val() > 180) {
                alert(
                    "Longitude must be between -180 and 180 degrees inclusive."
                );
            }
        }
    });

    /*************************************************************/
    // live-searches //
    /*************************************************************/

    // Packages live search
    jQuery("#package")
        .off("keyup")
        .on("keyup", function (e) {
            e.preventDefault();

            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/packagesType",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                beforeSend: function () {
                    jQuery("button[type=submit]").prop("disabled", true);
                },
                success: function (response) {
                    jQuery("#packages_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#packages_list").empty();
                        document.getElementById("package_id").value = "";
                        document.getElementById("package_price").value = "";
                        document.getElementById(
                            "package_price"
                        ).readOnly = false;
                        const hiddenPrice = document.getElementById(
                            "package_price_hidden"
                        );
                        jQuery("button[type=submit]").prop("disabled", false);

                        if (hiddenPrice) {
                            hiddenPrice.value = "";
                        }
                    }
                },
            });
        });

    $("#packages_list").on("click", ".list-group-item", function () {
        const id = $(this).attr("id");
        const price = $(this).attr("price");
        const currency = $(this).attr("currency");
        const content = $(this).attr("content");

        if (id) jQuery("button[type=submit]").prop("disabled", false);

        document.getElementById("package").value = content;
        document.getElementById("package_id").value = id;

        if (price) {
            document.getElementById("package_price").readOnly = true;
            document.getElementById("package_price").value = price;
            const hiddenPrice = document.getElementById("package_price_hidden");

            if (hiddenPrice) {
                hiddenPrice.value = price;
            }

            $("#package_price_currency").val(currency);
        }

        $("#packages_list").empty();
    });

    // Receiver type live search

    jQuery("#receiver_type")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();
            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/equipmentTypes",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                beforeSend: function () {
                    jQuery("button[type=submit]").prop("disabled", true);
                },
                success: function (response) {
                    jQuery("#receiver_type_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#receiver_type_list").empty();
                        document.getElementById("receiver_type_id").value = "";
                        jQuery("button[type=submit]").prop("disabled", false);
                    }
                },
            });
        });

    $("#receiver_type_list").on("click", ".list-group-item", function () {
        var val = $(this).text();
        var id = $(this).attr("id");

        if (id) jQuery("button[type=submit]").prop("disabled", false);

        document.getElementById("receiver_type").value = val;
        document.getElementById("receiver_type_id").value = id;

        jQuery("#receiver_type_list").empty();
    });

    // Router type live search

    jQuery("#router_type")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();
            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/equipmentTypes",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                beforeSend: function () {
                    jQuery("button[type=submit]").prop("disabled", true);
                },
                success: function (response) {
                    jQuery("#router_type_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#router_type_list").empty();
                        document.getElementById("router_type_id").value = "";
                        jQuery("button[type=submit]").prop("disabled", false);
                    }
                },
            });
        });

    $("#router_type_list").on("click", ".list-group-item", function () {
        var val = $(this).text();
        var id = $(this).attr("id");

        if (id) jQuery("button[type=submit]").prop("disabled", false);

        document.getElementById("router_type").value = val;
        document.getElementById("router_type_id").value = id;

        jQuery("#router_type_list").empty();
    });

    // Commission live search
    jQuery("#commission")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();
            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/commissions/search",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                beforeSend: function () {
                    jQuery("button[type=submit]").prop("disabled", true);
                },
                success: function (response) {
                    jQuery("#commission_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#commission_list").empty();
                        document.getElementById("commission_id").value = "";
                        jQuery("button[type=submit]").prop("disabled", false);
                    }
                },
            });
        });

    $("#commission_list").on("click", ".list-group-item", function () {
        var val = $(this).text();
        var id = $(this).attr("id");

        if (id) jQuery("button[type=submit]").prop("disabled", false);

        document.getElementById("commission").value = val;
        document.getElementById("commission_id").value = id;

        jQuery("#commission_list").empty();
    });

    // Marketer Live Search
    jQuery("#marketer")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();
            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/marketers/search",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                beforeSend: function () {
                    jQuery("button[type=submit]").prop("disabled", true);
                },
                success: function (response) {
                    jQuery("#marketers_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#marketers_list").empty();
                        document.getElementById("marketer_id").value = "";
                        jQuery("button[type=submit]").prop("disabled", false);
                    }
                },
            });
        });

    $("#marketers_list").on("click", ".list-group-item", function () {
        var val = $(this).text();
        var id = $(this).attr("id");

        if (id) jQuery("button[type=submit]").prop("disabled", false);

        document.getElementById("marketer").value = val;
        document.getElementById("marketer_id").value = id;

        jQuery("#marketers_list").empty();
    });

    // Provider Live Search
    jQuery("#provider")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();
            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/providers/search",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                beforeSend: function () {
                    jQuery("button[type=submit]").prop("disabled", true);
                },
                success: function (response) {
                    jQuery("#providers_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#providers_list").empty();
                        document.getElementById("provider_id").value = "";
                        jQuery("button[type=submit]").prop("disabled", false);
                    }
                },
            });
        });

    $("#providers_list").on("click", ".list-group-item", function () {
        var val = $(this).text();
        var id = $(this).attr("id");

        if (id) jQuery("button[type=submit]").prop("disabled", false);

        document.getElementById("provider").value = val;
        document.getElementById("provider_id").value = id;

        jQuery("#providers_list").empty();
    });

    // mac address validation

    $("#reciever_mac")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();

            var val = $(this).val();
            var mac = $("#mac").val();
            var id = $("#customer_id").val();
            token = document.getElementsByName("_token")[0].content;

            if (val.length == "17" && mac == "sell") {
                jQuery.ajax({
                    url: ROOT_DIR + "/checkSellMac",
                    method: "post",
                    data: {
                        _token: token,
                        data: val,
                        id: id,
                    },
                    success: function (response) {
                        if (response == "true") {
                            jQuery("#reciever_mac").css(
                                "border-color",
                                "green"
                            );
                            jQuery("#submit").attr("disabled", false);
                        } else {
                            jQuery("#reciever_mac").css("border-color", "red");
                            jQuery("#submit").attr("disabled", true);
                        }
                    },
                });
            }

            if (val.length == "17" && mac == "leased") {
                jQuery.ajax({
                    url: ROOT_DIR + "/checkLeasedMac",
                    method: "post",
                    data: {
                        _token: token,
                        data: val,
                        id: id,
                    },
                    success: function (response) {
                        if (response == "true") {
                            jQuery("#reciever_mac").css(
                                "border-color",
                                "green"
                            );
                            jQuery("#submit").attr("disabled", false);
                        } else {
                            jQuery("#reciever_mac").css("border-color", "red");
                            jQuery("#submit").attr("disabled", true);
                        }
                    },
                });
            }
        });

    jQuery("#customer")
        .off()
        .on("keyup", function (e) {
            e.preventDefault();
            var data = jQuery(this).val();
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/getCustomer",
                method: "post",
                data: {
                    _token: token,
                    search: data,
                },
                success: function (response) {
                    jQuery("#customer_list").empty().html(response);
                },
                complete: function () {
                    if (data.length == 0) {
                        jQuery("#customer_list").empty();
                        document.getElementById("customer_id").value = "";
                    }
                },
            });
        });

    $("#customer_list").on("click", ".list-group-item", function () {
        const id = $(this).attr("id");
        const content = $(this).text();

        document.getElementById("customer").value = content;
        document.getElementById("customer_id").value = id;

        $("#customer_list").empty();
    });

    // filter amendments
    jQuery("#filter-area-amend").on(
        "click",
        ".filter-area-amend",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-amendment",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-amend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    // filter canceled amendments
    jQuery("#filter-area-amend").on(
        "click",
        ".filter-area-cancel-amend",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-amend-cancel",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-amend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-amend").on("click", ".pagination a", function (event) {
        event.preventDefault();
        var attr = $("#nav-tab button.active").attr("attr");
        var page = $(this).attr("href").split("page=")[1];
        fetch_amend_filter_data(page, attr);
    });

    function fetch_amend_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-amendment?page=" + page,
            success: function (data) {
                $("#filter-area-amend").empty().html(data);
            },
        });
    }

    // filter provincianl amendments
    jQuery("#filter-area-prAmend").on(
        "click",
        ".filter-area-prAmend",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-prAmendment",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-prAmend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    // filter provincianl amendments
    jQuery("#filter-area-prAmend").on(
        "click",
        ".filter-area-canceled-prAmend",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-pr-amend-cancel",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-prAmend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-prAmend").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_prAmend_filter_data(page, attr);
        }
    );

    function fetch_prAmend_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-prAmendment?page=" + page,
            success: function (data) {
                $("#filter-area-prAmend").empty().html(data);
            },
        });
    }

    // filter customers activations
    jQuery("#customer-filter-area").on(
        "click",
        ".customer-filter-area",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-customer",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#customer-filter-area").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#customer-filter-area").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_customer_filter_data(page, attr);
        }
    );

    function fetch_customer_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-customer?page=" + page,
            success: function (data) {
                $("#customer-filter-area").empty().html(data);
            },
        });
    }

    // filter provincial customers activations
    jQuery("#provincial-filter-area").on(
        "click",
        ".provincial-filter-area",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-provincial",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#provincial-filter-area").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#provincial-filter-area").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_provincial_filter_data(page, attr);
        }
    );

    function fetch_provincial_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-provincial?page=" + page,
            success: function (data) {
                $("#provincial-filter-area").empty().html(data);
            },
        });
    }

    // filter terminated customers
    jQuery("#filter-area-terminate").on(
        "click",
        ".filter-area-terminate",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-terminate",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-terminate").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    // filter terminated customers
    jQuery("#filter-area-terminate").on(
        "click",
        ".filter-area-recontract",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-recontract",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-terminate").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-terminate").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_terminate_filter_data(page, attr);
        }
    );

    function fetch_terminate_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-terminate?page=" + page,
            success: function (data) {
                $("#filter-area-terminate").empty().html(data);
            },
        });
    }

    // filter provincial terminated customers
    jQuery("#filter-area-pr-terminate").on(
        "click",
        ".filter-area-pr-terminate",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-pr-terminate",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-pr-terminate").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-pr-terminate").on(
        "click",
        ".filter-area-pr-recontract-terminate",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-prrecontract",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-pr-terminate").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-pr-terminate").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_pr_terminate_filter_data(page, attr);
        }
    );

    function fetch_pr_terminate_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-pr-terminate?page=" + page,
            success: function (data) {
                $("#filter-area-pr-terminate").empty().html(data);
            },
        });
    }

    // filter suspend customers
    jQuery("#filter-area-suspend").on(
        "click",
        ".filter-area-suspend",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-suspend",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-suspend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    // filter reactivate customers
    jQuery("#filter-area-suspend").on(
        "click",
        ".filter-area-reactivate",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-reactivate",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-suspend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-suspend").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_suspend_filter_data(page, attr);
        }
    );

    function fetch_suspend_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-suspend?page=" + page,
            success: function (data) {
                $("#filter-area-suspend").empty().html(data);
            },
        });
    }

    // filter provincial suspend customers
    jQuery("#filter-area-pr-suspend").on(
        "click",
        ".filter-area-pr-suspend",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-pr-suspend",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-pr-suspend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    // filter provincial suspend customers
    jQuery("#filter-area-pr-suspend").on(
        "click",
        ".filter-area-pr-reactivate",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-pr-reactivate",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-pr-suspend").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-pr-suspend").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_pr_suspend_filter_data(page, attr);
        }
    );

    function fetch_pr_suspend_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-pr-suspend?page=" + page,
            success: function (data) {
                $("#filter-area-pr-suspend").empty().html(data);
            },
        });
    }

    // filter cancel customers
    jQuery("#filter-area-cancel").on(
        "click",
        ".filter-area-cancel",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-cancel",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-cancel").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-cancel").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_cancel_filter_data(page, attr);
        }
    );

    function fetch_cancel_filter_data(page, attr) {
        jQuery.ajax({
            method: "get",
            data: {
                attr: attr,
            },
            url: ROOT_DIR + "/filter-cancel?page=" + page,
            success: function (data) {
                $("#filter-area-cancel").empty().html(data);
            },
        });
    }

    // filter provincial cancel customers
    jQuery("#filter-area-pr-cancel").on(
        "click",
        ".filter-area-pr-cancel",
        function (e) {
            e.preventDefault();

            var attr = jQuery(this).attr("attr");
            token = document.getElementsByName("_token")[0].content;

            jQuery.ajax({
                url: ROOT_DIR + "/filter-pr-cancel",
                method: "get",
                data: {
                    _token: token,
                    attr: attr,
                },
                success: function (response) {
                    $("#filter-area-pr-cancel").empty().html(response);
                    $("#filter-count").text($("#total").val());
                },
            });
        }
    );

    jQuery("#filter-area-pr-cancel").on(
        "click",
        ".pagination a",
        function (event) {
            event.preventDefault();
            var attr = $("#nav-tab button.active").attr("attr");
            var page = $(this).attr("href").split("page=")[1];
            fetch_pr_cancel_filter_data(page, attr);
        }
    );

    // filter cancel amendment in customers
    // jQuery('#filter-area-cancel-amend').on('click','.filter-area-cancel-amend',function(e){
    //     e.preventDefault();

    //     var attr = jQuery(this).attr('attr');
    //     token = document.getElementsByName("_token")[0].content;

    //     jQuery.ajax({
    //        url: ROOT_DIR + "/filter-amend-cancel",
    //        method:'get',
    //        data:{
    //             _token: token,
    //             attr:attr,
    //         },
    //         success:function(response){

    //          $('#filter-area-cancel-amend').empty().html(response);
    //          $('#filter-count').text($('#total').val());

    //         }
    //     });
    // });

    // jQuery('#filter-area-cancel-amend').on('click', '.pagination a', function(event){
    //     event.preventDefault();
    //     var attr = $('#nav-tab button.active').attr('attr');
    //     var page = $(this).attr('href').split('page=')[1];
    //     fetch_amend_cancel_filter_data(page, attr);
    // });

    // function fetch_amend_cancel_filter_data(page, attr){

    //     jQuery.ajax({
    //         method:'get',
    //         data:{
    //             attr: attr
    //         },
    //         url:ROOT_DIR + "/filter-amend-cancel?page="+page,
    //         success:function(data){
    //             $('#filter-area-cancel-amend').empty().html(data);
    //         }
    //     });

    // }

    // filter provincial cancel amendment in customers
    // jQuery('#filter-area-pr-cancel-amend').on('click','.filter-area-pr-cancel-amend',function(e){
    //     e.preventDefault();

    //     var attr = jQuery(this).attr('attr');
    //     token = document.getElementsByName("_token")[0].content;

    //     jQuery.ajax({
    //        url: ROOT_DIR + "/filter-pr-amend-cancel",
    //        method:'get',
    //        data:{
    //             _token: token,
    //             attr:attr,
    //         },
    //         success:function(response){

    //          $('#filter-area-pr-cancel-amend').empty().html(response);
    //          $('#filter-count').text($('#total').val());

    //         }
    //     });
    // });

    // jQuery('#filter-area-pr-cancel-amend').on('click', '.pagination a', function(event){
    //     event.preventDefault();
    //     var attr = $('#nav-tab button.active').attr('attr');
    //     var page = $(this).attr('href').split('page=')[1];
    //     fetch_pr_amend_cancel_filter_data(page, attr);
    // });

    // function fetch_pr_amend_cancel_filter_data(page, attr){

    //     jQuery.ajax({
    //         method:'get',
    //         data:{
    //             attr: attr
    //         },
    //         url:ROOT_DIR + "/filter-pr-amend-cancel?page="+page,
    //         success:function(data){
    //             $('#filter-area-pr-cancel-amend').empty().html(data);
    //         }
    //     });

    // }

    // updating branch triggers
    $("#province").on("change", function (e) {
        e.preventDefault();

        var province = $(this).val();
        token = document.getElementsByName("_token")[0].content;

        jQuery.ajax({
            url: ROOT_DIR + "/check/branch",
            method: "get",
            data: {
                _token: token,
                province: province,
            },
            success: function (response) {
                $("#branch_id").empty().append(response);
            },
        });
    });
});
