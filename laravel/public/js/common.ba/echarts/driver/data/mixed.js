define(function (require, c, b) {
    var a = require("echartsDriverDataLine");

    function e(m, l, f) {
        var n = [];
        var g = 0;
        for (var k in m.data) {
            var h = {};
            if (typeof m.data[k].data != "undefined") {
                h = m.data[k]
            } else {
                h = {name: k, data: m.data[k]}
            }
            if (l.type[g] == undefined) {
                l.type[g] = l.type[0]
            }
            h.type = l.type[g];
            n.push(h);
            g++
        }
        l.type = "line";
        m.data = n;
        var k =  a(m, l, f);
        k.grid = {x2:80};
        return k;
    }

    b.exports = e
});