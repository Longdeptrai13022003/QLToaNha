$(document).ready(function () {
    am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdiv");

        const myTheme = am5.Theme.new(root);

        myTheme.rule("AxisLabel", ["minor"]).setAll({
            dy:1
        });

        myTheme.rule("Grid", ["x"]).setAll({
            strokeOpacity: 0.05
        });

        myTheme.rule("Grid", ["x", "minor"]).setAll({
            strokeOpacity: 0.05
        });

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root),
            myTheme
        ]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            maxTooltipDistance: 0,
            pinchZoomX:true
        }));

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0.2,
            baseInterval: {
                timeUnit: "month",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {
                minorGridEnabled: true
            }),
            tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {}),
            max: 200000000,  // Đặt mức tối đa lớn hơn
            extraMax: 0.1
        }));

        function setSeries(loai, data){
            var series = chart.series.push(am5xy.LineSeries.new(root, {
                name: loai,
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                valueXField: "date",
                legendValueText: "{valueY.formatNumber('#,###,###')}", // Định dạng số trong legend
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "horizontal",
                    labelText: "{valueY.formatNumber('#,###,###')}" // Hiển thị giá trị có dấu chấm
                })
            }));

            series.data.setAll(data);
            series.appear();
        }

        function setCursor(){
            // Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none"
            }));
            cursor.lineY.set("visible", false);


// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal"
            }));

            chart.set("scrollbarY", am5.Scrollbar.new(root, {
                orientation: "vertical"
            }));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
            var legend = chart.rightAxesContainer.children.push(am5.Legend.new(root, {
                width: 200,
                paddingLeft: 15,
                height: am5.percent(100)
            }));
            console.log('Đã chạy vào setCusor');

// When legend item container is hovered, dim all the series except the hovered one
            legend.itemContainers.template.events.on("pointerover", function(e) {
                var itemContainer = e.target;

                // As series list is data of a legend, dataContext is series
                var series = itemContainer.dataItem.dataContext;

                chart.series.each(function(chartSeries) {
                    if (chartSeries != series) {
                        chartSeries.strokes.template.setAll({
                            strokeOpacity: 0.15,
                            stroke: am5.color(0x000000)
                        });
                    } else {
                        chartSeries.strokes.template.setAll({
                            strokeWidth: 3
                        });
                    }
                })
            })

// When legend item container is unhovered, make all series as they are
            legend.itemContainers.template.events.on("pointerout", function(e) {
                var itemContainer = e.target;
                var series = itemContainer.dataItem.dataContext;

                chart.series.each(function(chartSeries) {
                    chartSeries.strokes.template.setAll({
                        strokeOpacity: 1,
                        strokeWidth: 1,
                        stroke: chartSeries.get("fill")
                    });
                });
            })

            legend.itemContainers.template.set("width", am5.p100);
            legend.valueLabels.template.setAll({
                width: am5.p100,
                textAlign: "right"
            });

// It's is important to set legend data after all the events are set on template, otherwise events won't be copied
            legend.data.setAll(chart.series.values);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
            chart.appear(1000, 100);
        }
// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        $.ajax({
            url: 'index.php?r=danh-muc/get-chart-data',
            type: 'post',
            data: {toaNhaID: $('#toa-nha-id').val()},
            dataType: 'json',
            success: function(data) {
                if (data.success){
                    setSeries('Tổng thu',data.dataThu);
                    setSeries('Tổng chi',data.dataChi);
                    setSeries('Lợi nhuận',data.dataLoiNhuan);
                    setCursor();
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    }); // end am5.ready()
    $(document).on('change', '#toa-nha-id', function (e) {
        e.preventDefault();

        var toaNhaID = $(this).val();

        if (!toaNhaID) return;

        // Xóa dữ liệu cũ
        chart.series.each(function(series) {
            series.data.clear();
        });

        // Gọi Ajax để lấy dữ liệu mới
        $.ajax({
            url: 'index.php?r=danh-muc/get-chart-data',
            type: 'post',
            data: { toaNhaID: toaNhaID },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    setSeries('Tổng thu', data.dataThu);
                    setSeries('Tổng chi', data.dataChi);
                    setSeries('Lợi nhuận',data.dataLoiNhuan);
                    $('.tong_thu').html(data.tongThu);
                    $('.tong_chi').html(data.tongChi);
                    $('.loi_nhuan').html(data.loiNhuan);
                }
            },
            error: function(r1, r2) {
                console.log(r1);
            }
        });
    });
});