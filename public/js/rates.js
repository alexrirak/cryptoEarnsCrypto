$(document).ready(function() {
    var rateTable = $('#rateTable').DataTable( {
        responsive: true,
        ajax: {
            url: '/api/rate-stats/' + $("h1[data-provider]").attr('data-provider'),
            dataSrc: function (json) {
                // maps the return data to the data we want to show in the table
                var return_data = new Array();
                for(var i=0;i< json.length; i++) {
                    rateChange = json[i].prior_rate ? [parseFloat(json[i].latest_rate) - parseFloat(json[i].prior_rate)] : []
                    specialRateChange = json[i].prior_rate ? [parseFloat(json[i].latest_special_rate) - parseFloat(json[i].prior_special_rate)] : []
                    return_data.push([
                        [json[i].name, "<img class='coinLogo' src='" + json[i].image + "' alt='" + json[i].name + "' title='" + json[i].name + "'/><span style='display:none'>" + json[i].name + "</span>"],
                        json[i].symbol,
                        [parseFloat(json[i].latest_rate),
                            "<span data-type='specialRate' style='display: none'>"
                            + (parseFloat(json[i].latest_special_rate) * 100).toFixed(2) + " %"
                            + "</span><span data-type='rate'>"
                            + (parseFloat(json[i].latest_rate) * 100).toFixed(2) + " %"
                            + "</span>"],
                        json[i].prior_rate
                        ? [parseFloat(json[i].prior_rate),
                            "<span data-type='specialRate' style='display: none'>"
                            + (parseFloat(json[i].prior_special_rate) * 100).toFixed(2) + " %"
                            + "</span><span data-type='rate'>"
                            + (parseFloat(json[i].prior_rate) * 100).toFixed(2) + " %"
                            + "</span>"]
                        : ["<span class='badge bg-secondary'>Unknown<sup>*</sup></span>"],
                        json[i].prior_rate
                        ? [rateChange,
                            "<span class='badge " + (rateChange > 0 ? "bg-success" : "bg-danger") + "'>"
                            + "<span data-type='specialRate' style='display: none'>"
                            + (specialRateChange * 100).toFixed(2) + " %"
                            + "</span><span data-type='rate'>"
                            + (rateChange * 100).toFixed(2) + " %"
                            + "</span></span>"]
                        : ["<span class='badge bg-secondary'>Unknown<sup>*</sup></span>"],
                        json[i].latest_date ? new Date(json[i].latest_date).toDateString() : "<span class='badge bg-secondary'>Unknown<sup>*</sup></span>"
                    ]);
                }
                return return_data;
            }
        },
        columns: [
            {
                render: function (data, type) {
                    return type === 'sort' ? data[0] : data[1];
                }
            },
            { },
            {
                render: function (data, type) {
                    return type === 'sort' ? data[0] : data[1];
                }
            },
            {
                render: function (data, type) {
                    return type === 'sort' ? data[0] : data[1] ? data[1] : data[0];
                }
            },
            {
                render: function (data, type) {
                    return type === 'sort' ? data[0] : data[1] ? data[1] : data[0];
                }
            },
            { }
        ],
        dom: "<'row'<'#length-switch.col-sm-12 col-md-3 mb-1'l><'#rate-switch.col-sm-12 col-md-3 mb-1'><'#favorite-button.col-sm-12 col-md-3 mb-1'><'#search.col-sm-12 col-md-3 mb-1'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "initComplete": function() {

            specialRate = $("h1[data-provider-rate]").attr('data-provider-rate')
            if (specialRate != "") {
                $("#rate-switch").html("<button type=\"button\" class=\"btn btn-outline-secondary\" data-rate-label=\"" + specialRate + "\" special-rate-selected='false'>Show " + specialRate + "</button>");

                $("[data-rate-label]").click(function() {

                    if ($("[special-rate-selected]").attr('special-rate-selected') === 'false'){
                        $("[data-rate-label]").html("Hide " + $("[data-rate-label]").attr('data-rate-label'));
                        $("[data-type='rate']").hide();
                        $("[data-type='specialRate']").show();
                        $("td:has(\"[data-type='specialRate']\")").addClass("flash");
                        $("[special-rate-selected]").attr('special-rate-selected','true');
                    } else if ($("[special-rate-selected]").attr('special-rate-selected') === 'true'){
                        $("[data-rate-label]").html("Show " + $("[data-rate-label]").attr('data-rate-label'));
                        $("[data-type='specialRate']").hide();
                        $("[data-type='rate']").show();
                        $("td:has(\"[data-type='rate']\")").addClass("flash");
                        $("[special-rate-selected]").attr('special-rate-selected','false');
                    }

                    setTimeout( function(){
                        $("td.flash").removeClass("flash")
                    }, 1000);

                    $(this).blur();

                });

                $("#favorite-button").html("<button type=\"button\" class=\"btn btn-outline-secondary\" ><i class=\"bi bi-star-fill\"></i> Add Favorites <i class=\"bi bi-star-fill\"></i></button>");
            }
        }
    });

    // When a collapsed row is opened we need to do a check for which rate to show
    rateTable.on( 'responsive-display', function (  ) {
        if ($("[special-rate-selected]").attr('special-rate-selected') === 'true'){
            $("[data-type='rate']").hide();
            $("[data-type='specialRate']").show();
        } else if ($("[special-rate-selected]").attr('special-rate-selected') === 'false'){
            $("[data-type='specialRate']").hide();
            $("[data-type='rate']").show();
        }
    } );

    // When a page is changed we need to do a check for which rate to show
    rateTable.on( 'draw', function () {
        if ($("[special-rate-selected]").attr('special-rate-selected') === 'true'){
            $("[data-type='rate']").hide();
            $("[data-type='specialRate']").show();
        } else if ($("[special-rate-selected]").attr('special-rate-selected') === 'false'){
            $("[data-type='specialRate']").hide();
            $("[data-type='rate']").show();
        }
    } );
});
