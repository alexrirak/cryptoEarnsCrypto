$(document).ready(function() {
    var rateTable = $('#rateTable').DataTable( {
        responsive: true,
        ajax: {
            url: '/api/rate-stats/Celsius',
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
        ]
    });
});
