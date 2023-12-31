$(function () {
    "use strict";
    Morris.Donut({
        element: "morris-donut-chart",
        data: [{label: "Download Sales", value: 12}, {label: "In-Store Sales", value: 30}, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: !0,
        colors: ["#4680ff", "#26DAD2", "#fc6180"]
    }), Morris.Area({
        element: "morris-area-chart",
        data: [{period: "2001", smartphone: 0, windows: 0, mac: 0}, {
            period: "2002",
            smartphone: 90,
            windows: 60,
            mac: 25
        }, {period: "2003", smartphone: 40, windows: 80, mac: 35}, {
            period: "2004",
            smartphone: 30,
            windows: 47,
            mac: 17
        }, {period: "2005", smartphone: 150, windows: 40, mac: 120}, {
            period: "2006",
            smartphone: 25,
            windows: 80,
            mac: 40
        }, {period: "2007", smartphone: 10, windows: 10, mac: 10}],
        xkey: "period",
        ykeys: ["smartphone", "windows", "mac"],
        labels: ["Phone", "Windows", "Mac"],
        pointSize: 3,
        fillOpacity: 0,
        pointStrokeColors: ["#26DAD2", "#4680ff", "#fc6180"],
        behaveLikeLine: !0,
        gridLineColor: "#e0e0e0",
        lineWidth: 3,
        hideHover: "auto",
        lineColors: ["#26DAD2", "#4680ff", "#fc6180"],
        resize: !0
    })
});
