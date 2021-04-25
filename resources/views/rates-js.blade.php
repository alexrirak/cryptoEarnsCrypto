<script>
    $(document).ready(function() {
        var rateTable = $('#rateTable').DataTable( {
            responsive: true,
            ajax: {
                url: '/api/rate-stats/' + $("h1[data-provider]").attr('data-provider') @auth+ '?user={{ Auth::user()->id }}'@endauth,
                dataSrc: function (json) {
                    // maps the return data to the data we want to show in the table
                    var return_data = new Array();
                    for(var i=0;i< json.length; i++) {
                        rateChange = json[i].prior_rate ? [parseFloat(json[i].latest_rate) - parseFloat(json[i].prior_rate)] : []
                        specialRateChange = json[i].prior_rate ? [parseFloat(json[i].latest_special_rate) - parseFloat(json[i].prior_special_rate)] : []
                        return_data.push([
                            @auth
                                @desktop
                                [json[i].favorite * -1,
                                json[i].favorite === 1
                                    ? "<div class='coinLogoHolder'><img class='coinLogo' src='" + json[i].image + "' alt='" + json[i].name + "' title='" + json[i].name + "'/><i coin='"+json[i].symbol+"' class=\"bi bi-star-fill favoriteStar\"></i></div>"
                                    : "<div class='coinLogoHolder'><img class='coinLogo' src='" + json[i].image + "' alt='" + json[i].name + "' title='" + json[i].name + "'/><i coin='"+json[i].symbol+"' class=\"bi bi-star favoriteStar\"></i></div>"],
                                @elsedesktop
                                [json[i].favorite * -1,"<img class='coinLogo' src='" + json[i].image + "' alt='" + json[i].name + "' title='" + json[i].name + "'/>"],
                                @enddesktop
                            @else
                                ["<img class='coinLogo' src='" + json[i].image + "' alt='" + json[i].name + "' title='" + json[i].name + "'/>"],
                            @endauth
                            json[i].name,
                            json[i].symbol,
                            @auth [json[i].favorite * -1,json[i].favorite === 1 ? "<button type='button' class='btn btn-outline-secondary' coin='" + json[i].symbol + "'><i class='bi bi-star-fill'></i></button>" : "<button type='button' class='btn btn-outline-secondary' coin='" + json[i].symbol + "'><i class='bi bi-star'></i></button>"], @endauth
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
                { // shows image, not searchable
                    "searchable": false,
                    render: function (data, type) {
                        return type === 'sort' ? data[0] : data[1] ? data[1] : data[0];
                    }
                },
                {
                    //name, hidden but searchable
                    "visible": false,
                },
                {
                    // symbol/ticker
                },
                @auth {
                    // favorites
                    "visible": false,
                    "searchable": false,
                    render: function (data, type) {
                        return type === 'sort' ? data[0] : data[1] ? data[1] : data[0];
                    }
                }, @endauth
                { // current rate, decimal for sort, converted to percent for display
                    render: function (data, type) {
                        return type === 'sort' ? data[0] : data[1];
                    }
                },
                {  // prior rate, decimal for sort, converted to percent for display or unknown if none
                    render: function (data, type) {
                        return type === 'sort' ? data[0] : data[1] ? data[1] : data[0];
                    }
                },
                {  // change, decimal for sort, converted to percent for display or unknown if none
                    render: function (data, type) {
                        return type === 'sort' ? data[0] : data[1] ? data[1] : data[0];
                    }
                },
                {
                  // date string or unknown fixme: make this sortable
                }
            ],
            "order": [[ 0, 'asc' ],[ 1, 'asc' ]],
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

                    @auth
                    $("#favorite-button").html("<button type=\"button\" class=\"btn btn-outline-secondary\" ><i class=\"bi bi-star-fill\"></i> Manage Favorites <i class=\"bi bi-star-fill\"></i></button>");
                    $("#favorite-button").click(function() {
                        var favoritesColumn = rateTable.column(3);
                        if (!favoritesColumn.visible()) {
                            favoritesColumn.visible( ! favoritesColumn.visible() );
                            $('#rateTable').width('100%');
                            favoriteButtonBinding(rateTable);
                            @desktop
                                $("i[coin]").each(function( index, element) {
                                    var relatedElement = $("button[coin='" + $(element).attr('coin') + "']")
                                    if($(element).hasClass('bi-star-fill') && !relatedElement.find("i").hasClass('bi-star-fill')) {
                                        relatedElement.find("i").removeClass("bi-star");
                                        relatedElement.find("i").addClass("bi-star-fill");
                                        relatedElement.attr('data-bs-original-title','Removed!');
                                    } else if ($(element).hasClass('bi-star') && !relatedElement.find("i").hasClass('bi-star')) {
                                        relatedElement.find("i").removeClass("bi-star-fill");
                                        relatedElement.find("i").addClass("bi-star");
                                        relatedElement.attr('data-bs-original-title','Added!');
                                    }
                                })
                            @enddesktop
                        } else {
                            $("button[coin]").off("click");
                            favoritesColumn.visible( ! favoritesColumn.visible() );
                            $('#rateTable').width('100%');
                        }
                    });


                    @else
                    $("#favorite-button").html("<button type=\"button\" class=\"btn btn-outline-secondary\" ><i class=\"bi bi-star-fill\"></i> Add Favorites <i class=\"bi bi-star-fill\"></i></button>");
                    @endauth
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
            @auth
                @desktop
                    favoriteStarBinding(rateTable);
                @enddesktop
                favoriteButtonBinding(rateTable);
            @endauth
        } );
    });

    @auth
        function favoriteAddedToast(coin) {
            toastr.success(coin + " added to favorites!");
        }

        function favoriteRemovedToast(coin) {
            toastr.success(coin + " removed from favorites!");
        }

        function favoriteErrorToast() {
            toastr.error("Error occurred updating favorites. Please try again.");
        }

        function favoriteButtonBinding(rateTable) {
            $("button[coin]").off("click");
            $("button[coin]").click(function() {
                if($(this).find("i").hasClass("bi-star")) {
                    $(this).find("i").removeClass("bi-star");
                    $(this).find("i").addClass("bi-star-fill");

                    @desktop
                        $("i[coin=" + $(this).attr('coin') + "]").removeClass("bi-star");
                        $("i[coin=" + $(this).attr('coin') + "]").addClass("bi-star-fill");
                    @enddesktop

                    var element = this;

                    $.ajax({
                        url: '{{ route('addFavorite', ['provider' => Str::lower($provider), 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'.replace("-coin-", $(this).attr('coin')),
                        type: 'PUT',
                        success: function() {
                            favoriteAddedToast($(element).attr('coin'))
                            $(element).blur();
                        }
                    }).fail(function() {
                        favoriteErrorToast();
                        $(element).blur();
                        //revert to original state
                        $(element).find("i").removeClass("bi-star-fill");
                        $(element).find("i").addClass("bi-star");

                        @desktop
                            $("i[coin=" + $(element).attr('coin') + "]").removeClass("bi-star-fill");
                            $("i[coin=" + $(element).attr('coin') + "]").addClass("bi-star");
                        @enddesktop
                    });


                } else if ($(this).find("i").hasClass("bi-star-fill")) {
                    $(this).find("i").removeClass("bi-star-fill");
                    $(this).find("i").addClass("bi-star");

                    @desktop
                        $("i[coin=" + $(this).attr('coin') + "]").removeClass("bi-star-fill");
                        $("i[coin=" + $(this).attr('coin') + "]").addClass("bi-star");
                    @enddesktop

                    var element = this;

                    $.ajax({
                        url: '{{ route('deleteFavorite', ['provider' => Str::lower($provider), 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'.replace("-coin-", $(this).attr('coin')),
                        type: 'DELETE',
                        success: function() {
                            favoriteRemovedToast($(element).attr('coin'));
                            $(element).blur();
                        }
                    }).fail(function() {
                        favoriteErrorToast();
                        $(element).blur();
                        //revert to original state
                        $(element).find("i").removeClass("bi-star");
                        $(element).find("i").addClass("bi-star-fill");

                        @desktop
                            $("i[coin=" + $(this).attr('coin') + "]").removeClass("bi-star");
                            $("i[coin=" + $(this).attr('coin') + "]").addClass("bi-star-fill");
                        @enddesktop
                    });
                }
                if(rateTable) {
                    rateTable.ajax.reload(null, false);
                }
            });
        }
        @desktop
        function favoriteStarBinding(rateTable) {
            $(".favoriteStar").off("click");
            $(".favoriteStar").click(function() {
                if($(this).hasClass("bi-star")) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");

                    var relatedElement = $("button[coin='" + $(this).attr('coin') + "']")

                    relatedElement.find("i").removeClass("bi-star");
                    relatedElement.find("i").addClass("bi-star-fill");

                    var element = this;

                    $.ajax({
                        url: '{{ route('addFavorite', ['provider' => Str::lower($provider), 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'.replace("-coin-", $(this).attr('coin')),
                        type: 'PUT',
                        success: function() {
                            favoriteAddedToast($(element).attr('coin'));
                        }
                    }).fail(function() {
                        favoriteErrorToast();
                        //revert to original state
                        $(element).removeClass("bi-star-fill");
                        $(element).addClass("bi-star");

                        relatedElement.find("i").removeClass("bi-star-fill");
                        relatedElement.find("i").addClass("bi-star");
                    });
                } else if ($(this).hasClass("bi-star-fill")) {
                    $(this).removeClass("bi-star-fill");
                    $(this).addClass("bi-star");

                    var relatedElement = $("button[coin='" + $(this).attr('coin') + "']")

                    relatedElement.find("i").removeClass("bi-star-fill");
                    relatedElement.find("i").addClass("bi-star");

                    var element = this;

                    $.ajax({
                        url: '{{ route('deleteFavorite', ['provider' => Str::lower($provider), 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'.replace("-coin-", $(this).attr('coin')),
                        type: 'DELETE',
                        success: function() {
                            favoriteRemovedToast($(element).attr('coin'))
                        }
                    }).fail(function() {
                        favoriteErrorToast();
                        //revert to original state
                        $(element).removeClass("bi-star");
                        $(element).addClass("bi-star-fill");

                        relatedElement.find("i").removeClass("bi-star");
                        relatedElement.find("i").addClass("bi-star-fill");
                    });
                }
                if(rateTable) {
                    rateTable.ajax.reload(null, false);
                }
        })};
        @enddesktop

        toastr.options = {
            "positionClass": "toast-bottom-right",
        }
    @endauth

</script>
