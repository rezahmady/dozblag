

<style>
.k-tilelayout {
    background-color: #f1f4f8;
}
.k-card-header {
    border-color: rgb(231, 234, 238);
    color: #848484;
    background-color: rgb(255, 255, 255);
    border: none;
}
.k-card {
    border-color: rgb(231, 234, 238);
    color: #848484;
    background-color: #fff;
    box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.08) !important;
    border: none;
        border-top-width: medium;
        border-right-width: medium;
        border-bottom-width: medium;
        border-left-width: medium;
}
</style>
  
<div id="example">
    <div id="tilelayout"></div>
</div>


 

@push('after_scripts')
{{-- <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script> --}}
<script src="https://kendo.cdn.telerik.com/2021.1.119/js/kendo.all.min.js"></script>

<!-- INITIALIZATION -->
<script>
    jQuery(document).ready(function($) {
        $("#tilelayout").kendoTileLayout({
            containers: [{
                colSpan: 3,
                rowSpan: 2,
                header: {
                    text: "نمودار فرصت ها"
                },
                bodyTemplate: kendo.template($("#views-chart-template").html())
            }, {
                colSpan: 1,
                rowSpan: 1,
                header: {
                    text: "Conversion Rate"
                },
                bodyTemplate: kendo.template($("#conversion-rate").html())
            }, {
                colSpan: 1,
                rowSpan: 1,
                header: {
                    text: "Currently"
                },
                bodyTemplate: kendo.template($("#current").html())
            }, {
                colSpan: 2,
                rowSpan: 1,
                header: {
                    text: "Most Visited Pages"
                },
                bodyTemplate: kendo.template($("#pages-chart-template").html())
            }, {
                colSpan: 2,
                rowSpan: 2,
                header: {
                    text: "Conversions by Channel"
                },
                bodyTemplate: kendo.template($("#conversions-grid-template").html())
            }, {
                colSpan: 1,
                rowSpan: 1,
                header: {
                    text: "Bounce Rate"
                },
                bodyTemplate: kendo.template($("#bounce-rate").html())
            }, {
                colSpan: 2,
                rowSpan: 2,
                header: {
                    text: "Users by Channel"
                },
                bodyTemplate: kendo.template($("#users-grid-template").html())
            }, {
                colSpan: 1,
                rowSpan: 2,
                header: {
                    text: "Visitors"
                },
                bodyTemplate: kendo.template($("#visitors-chart-template").html())
            }, {
                colSpan: 2,
                rowSpan: 1,
                header: {
                    text: "Conversion This Month"
                },
                bodyTemplate: kendo.template($("#conversion-chart-template").html())
            }],
            columns: 5,
            columnsWidth: 300,
            rowsHeight: 235,
            reorderable: true,
            resizable: true,
            resize: function (e) {
                var rowSpan = e.container.css("grid-column-end");
                var chart = e.container.find(".k-chart").data("kendoChart");
                // hide chart labels when the space is limited
                if (rowSpan === "span 1" && chart) {
                    chart.options.categoryAxis.labels.visible = false;
                    chart.redraw();
                }
                // show chart labels when the space is enough
                if (rowSpan !== "span 1" && chart) {
                    chart.options.categoryAxis.labels.visible = true;
                    chart.redraw();
                }

                // for widgets that do not auto resize
                // https://docs.telerik.com/kendo-ui/styles-and-layout/using-kendo-in-responsive-web-pages
                kendo.resize(e.container, true);
            }
        });

        var gridDs = new kendo.data.DataSource({
            data: [
                { channel: "جستجوی", conversion: 8232, users: 70500 },
                { channel: "مستقیم", conversion: 6574, users: 24900 },
                { channel: "ارجاع شده", conversion: 4932, users: 20000 },
                { channel: "شبکه های اجتماعی", conversion: 2928, users: 19500 },
                { channel: "ایمیل", conversion: 2456, users: 18100 },
                { channel: "سایر", conversion: 1172, users: 16540 },
            ],
            schema: {
                model: {
                    fields: {
                        conversion: { type: "number" },
                        users: { type: "number" }
                    }
                }
            }
        });

        $("#conversions-grid").kendoGrid({
            dataSource: gridDs,
            columns: [{
                field: "channel", title: "Channel", width: 100
            }, {
                field: "conversion", title: "Conversion", format: "{0:n0}", width: 80
            }],
        });

        $("#users-grid").kendoGrid({
            dataSource: gridDs,
            columns: [{
                field: "channel", title: "Channel", width: 100
            }, {
                field: "users", title: "Users", format: "{0:n0}", width: 80
            }]
        });

        function createCharts() {
            var showLabels = $(document).width() > 677;

            $("#views-chart").kendoChart({
                dataSource: {
                    data: [
                        { value: 2000, date: new Date(2020, 2, 30) },
                        { value: 80000, date: new Date(2020, 3, 5) },
                        { value: 130000, date: new Date(2020, 3, 10) },
                        { value: 170000, date: new Date(2020, 3, 15) },
                        { value: 190000, date: new Date(2020, 3, 20) },
                        { value: 150000, date: new Date(2020, 3, 25) },
                        { value: 160000, date: new Date(2020, 3, 30) }]
                },
                legend: {
                    visible: false
                },
                seriesDefaults: {
                    type: "line",
                    style: "smooth",
                    markers: {
                        visible: false
                    }
                },
                series: [{
                    field: "value",
                    categoryField: "date"
                }],
                valueAxis: {
                    line: {
                        width: 0
                    },
                    labels: {
                        step: 2
                    },
                    min: 0,
                    max: 200000,
                },
                categoryAxis: {
                    baseUnit: "fit",
                    labels: {
                        rotation:"auto",
                        format: "{0:d MMMM}",
                        visible: showLabels
                    },
                    majorGridLines: {
                        visible: false
                    },
                    majorTicks: {
                        visible: false
                    }
                }
            });

            $("#pages-chart").kendoChart({
                legend: {
                    visible: false
                },
                seriesDefaults: {
                    type: "column"
                },
                series: [{
                    data: [90000, 60000, 40000, 30000, 10000]
                }],
                valueAxis: {
                    line: {
                        width: 0
                    },
                    labels: {
                        step: 5
                    },
                    majorUnit: 10000,
                    min: 0,
                    max: 100000
                },
                categoryAxis: {
                    categories: ["Home", "Price", "Sign-up", "Product", "Blog"],
                    labels: {
                        rotation: "auto",
                        visible: showLabels
                    },
                    majorGridLines: {
                        visible: false
                    },
                    majorTicks: {
                        visible: false
                    }
                }
            });

            $("#conversion-chart").kendoChart({
                dataSource: {
                    data: [
                        { value: 2000, date: new Date(2020, 3, 1) },
                        { value: 80000, date: new Date(2020, 3, 5) },
                        { value: 130000, date: new Date(2020, 3, 10) },
                        { value: 170000, date: new Date(2020, 3, 15) },
                        { value: 190000, date: new Date(2020, 3, 20) },
                        { value: 190000, date: new Date(2020, 3, 30) }
                    ]
                },
                legend: {
                    visible: false
                },
                seriesDefaults: {
                    type: "line",
                    style: "smooth",
                    markers: {
                        visible: false
                    }
                },
                series: [{
                    field: "value",
                    categoryField: "date"
                }],
                valueAxis: {
                    line: {
                        width: 0
                    },
                    labels: {
                        step: 2
                    },
                    min: 0,
                    max: 200000,
                },
                categoryAxis: {
                    baseUnitStep: "auto",
                    autoBaseUnitSteps: {
                        days: [9]
                    },  
                    labels: {
                        rotation: "auto",
                        format: "{0:d MMMM}",
                        visible: showLabels
                    },
                    majorGridLines: {
                        visible: false
                    },
                    majorTicks: {
                        visible: false
                    }
                }
            });

            $("#visitors-chart").kendoChart({
                dataSource: {
                    data: [
                        { value: 70, type: "New" },
                        { value: 30, type: "Returning" },
                    ]
                },
                series: [{
                    type: "donut",
                    field: "value",
                    categoryField: "type",
                    startAngle: 70,
                    holeSize: 30
                }],
                legend: {
                    position: "bottom"
                }
            });

            kendo.resize($(".k-grid"));
        }

        $(document).ready(createCharts);
        $(document).bind("kendo:skinChange", createCharts);

        $(window).on("resize", function () {
            kendo.resize($(".k-chart"));
        });
    });
</script>


    <!-- container text templates -->
    <script id="conversion-rate" type="text/x-kendo-template">
        <h3>9%</h3>
        <div>Visitor to Customer</div>
    </script>
    <script id="current" type="text/x-kendo-template">
        <h3>2, 399</h3>
        <div>Active users right now</div>
        <div>Active users right now</div>
    </script>
    <script id="bounce-rate" type="text/x-kendo-template">
        <h1>55 %</h1>
        <div>The percentage of all sessions on your site in which users viewed only a single page.</div>
    </script>

    <!-- container chart templates -->
    <script id="pages-chart-template" type="text/x-kendo-template">
        <div id="pages-chart" style="height:100%; width:100%"></div>
    </script>
    <script id="views-chart-template" type="text/x-kendo-template">
        <div id="views-chart" style="height:100%; width:100%"></div>
    </script>
    <script id="visitors-chart-template" type="text/x-kendo-template">
        <div id="visitors-chart" style="height:100%; width:100%"></div>
    </script>
    <script id="conversion-chart-template" type="text/x-kendo-template">
        <div id="conversion-chart" style="height:100%; width:100%"></div>
    </script>

    <!-- container grid templates -->
    <script id="conversions-grid-template" type="text/x-kendo-template">
        <div id="conversions-grid" style="height:100%;"></div>
    </script>
    <script id="users-grid-template" type="text/x-kendo-template">
        <div id="users-grid" style="height:100%;"></div>
    </script>

@endpush