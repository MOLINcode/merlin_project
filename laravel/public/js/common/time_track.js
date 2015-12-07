(function (window, $) {
    function TsbGraph(elem, data) {
        this.elem = elem;
        this.data = data;

        this.min = data.time_range[0];
        this.max = data.time_range[1];

        this.count = 8;
        this.space = 100 / this.count;

        this.padding = 10;

    }

    TsbGraph.prototype.init = function () {

        var _self = this;

        var graph = _self.graph = $('<div class="tsb-graph"></div>');

        var scale = _self.buildScale();
        var ticks = scale.ticks;
        var lines = scale.lines;

        var container = $('<div class="graph-container"></div>');

        var index = _self.buildIndex();

        container.append(index);

        var i = 0;
        for (var key in _self.data.tree) {
            var group = _self.buildTrance(key, _self.data.tree[key], i);
            container.append(group);
            i++;
        }

        graph.append(ticks);
        graph.append(lines);
        graph.append(container);

        _self.elem.append(graph);

        //tooltip
        var prePosLeft = 0;

        function graphMove(e) {
            var graphWidth = graph.width(),
                graphHeight = graph.outerHeight(),
                diffLeft = graphWidth * 0.2,
                diffTop = ticks.height(),
                range = graphWidth - diffLeft;

            var posLeft = e.pageX - graph.offset().left,
                posTop = e.pageY - graph.offset().top;

            if (posLeft - diffLeft >= 0 && posLeft - diffLeft <= range && posTop - diffTop > 0) {
                var opt = _self.queryIndexByPosition(posLeft - diffLeft, range);
                opt.request_number = _self.queryRequestsByPosition(posLeft - diffLeft, range).length;

                opt.left = posLeft > prePosLeft ? posLeft + 2 : posLeft - 2;
                opt.top = posTop;
                opt.info = $(this).data('graph_info');

                var tooltip = _self.buildTooltip(opt);

                graph.find('.graph-tooltip').remove();
                graph.append(tooltip);

                var tooltipInfo = tooltip.find('.graph-tooltip-info'),
                    tWidth = tooltipInfo.outerWidth(),
                    tHeight = tooltipInfo.outerHeight();

                if ((posLeft - diffLeft) > range / 2) {
                    tooltipInfo.css('left', posLeft - tWidth - 10);
                }
                if (posTop > graphHeight / 2) {
                    tooltipInfo.css('top', posTop - tHeight);
                }

                return false;
            } else {
                graph.find('.graph-tooltip').remove();
            }
        }

        graph.on('mousemove', graphMove)
            .on('mouseleave', function () {
                graph.find('.graph-tooltip').remove();
            })
            .on('mousemove', '.graph-item', graphMove)
        ;

        return _self;
    }

    /**
     * 生成刻度尺
     * @returns {{ticks: *, lines: *}}
     */
    TsbGraph.prototype.buildScale = function () {
        var _self = this;
        //生成刻度值
        function getInterval(min, max, count) {
            var intervals = [0];

            var range = max - min;
            var part = Math.ceil(range / count);

            var left = max;

            for (var i = 1; i < count + 1; i++) {
                left = left - part;
                if (left <= 0) {
                    _self.count = i;
                    intervals.push(max);
                    break;
                }
                intervals.push(min + part * i);
            }
            //重新设置max值
            _self.max = intervals[intervals.length - 1];

            return intervals;
        }

        //生成刻度
        function makeTick(intervals, space) {
            var ticks = '<div class="graph-scale">';
            for (var i = 0, l = intervals.length; i < l; i++) {
                var right = 100 - intervals[i] / intervals[intervals.length - 1] * 100;
                ticks += '<div class="graph-number" style="right: ' + right + '%;">' + intervals[i] + '</div>';
            }
            ticks += '</div>';

            return $(ticks);
        }

        //生成刻度线
        function makeLine(intervals, space) {
            var lines = '<div class="graph-lines">';
            for (var i = 0, l = intervals.length; i < l; i++) {
                lines += '<div class="graph-line" style="left: ' + space * i + '%;"></div>';
            }
            lines += '</div>';

            return $(lines);
        }

        var intervals = getInterval(_self.min, _self.max, _self.count);

        _self.space = 100 / _self.count;
        return {
            ticks: makeTick(intervals, _self.space),
            lines: makeLine(intervals, _self.space)
        };
    }
    /**
     * 生成指标数据
     * @returns {*|HTMLElement}
     */
    TsbGraph.prototype.buildIndex = function () {

        var _self = this;

        var item_key = {
            CPU: ['cpu_average', 'current_cpu'],
            Memory: ['memory_average', 'current_memory']
        };
        //生成cpu和memory项目
        function makeItem(title) {

            var average = _self.data[item_key[title][0]];
            var current_data = _self.data[item_key[title][1]];

            var item = $('<div class="graph-item">' +
                '<div class="graph-item-label">' +
                '<div class="graph-item-title">' + title + '</div>' +
                '<div class="graph-item-data">' +
                '<div class="graph-item-key">' + lang_chart_tip.avg + '</div>' +
                '<div class="graph-item-value">' + average + '</div>' +
                '</div>' +
                '</div>' +
                '<div class="graph-item-place"></div>' +
                '</div>');

            var place = item.find('.graph-item-place');

            var start = _self.min;

            for (var time in current_data) {
                var info = {
                    start: start,
                    end: time,
                    value: current_data[time]
                };
                var width = (time - start) / _self.max * 100 + '%';
                var left = start / _self.max * 100 + '%';

                var progress = $('<div class="graph-index-progress graph-cpu" style="width: ' + width + ';left: ' + left + ';"></div>');

                progress.data('graph_info', info);

                place.append(progress);

                start = time;

            }

            return item;

        }

        var group = $('<div class="graph-group graph-index"></div>');
        var title = $('<div class="graph-title">' + lang_chart_tip.item + '</div>');

        var cpu = makeItem('CPU');
        var memory = makeItem('Memory');

        group.append(title);
        group.append(cpu);
        group.append(memory);

        return group;

    }
    /**
     * 生成跟踪列表
     * @param title
     * @param data
     * @param index
     * @returns {*|HTMLElement}
     */
    TsbGraph.prototype.buildTrance = function (title, data, index) {
        if (data.length == 0) {
            return false;
        }
        var _self = this,
            padding = _self.padding * index;

        var group = $('<div class="graph-group"></div>');
        var title_dom = $('<div class="graph-title">' + lang_chart_tip[title] + '</div>');
        group.append(title_dom);

        for (var i = 0, l = data.length; i < l; i++) {
            var width = data[i].duration / _self.max * 100 + '%';
            var left = data[i].start_time / _self.max * 100 + '%';

            var str = '<div class="graph-item"><div class="graph-item-label"><div class="graph-item-title" style="padding-left:' + padding + 'px;" title="' + data[i].name + '">' + data[i].name + '</div></div><div class="graph-item-place">';
            str += '<div class="graph-trace-progress graph-' + title + '" style="width: ' + width + ';left:' + left + ';">';
            str += '</div></div></div>';
            var item = $(str);
            item.data('graph_info', data[i]);

            group.append(item);
        }


        return group;

    }
    /**
     * 生成tooltip
     * @param option
     * @returns {*|HTMLElement}
     */
    TsbGraph.prototype.buildTooltip = function (option) {
        var left = option.left,
            top = option.top;

        var tooltip = $('<div class="graph-tooltip"></div>');
        var line = $('<div class="graph-tooltip-line" style="left: ' + left + 'px;"></div>');

        var info = '<div class="graph-tooltip-info" style="left: ' + (left + 10) + 'px;top: ' + top + 'px;">';

        var title = '<div class="graph-tooltip-title">';
        if (typeof  option.time == 'number') {
            title += '<div class="graph-info-block">' + option.time + 'ms<br/>' + lang_chart_tip.time + '</div>'
        }
        if (option.cpu != null) {
            title += '<div class="graph-info-block">' + option.cpu + '<br/>CPU</div>'
        }
        if (option.memory != null) {
            title += '<div class="graph-info-block">' + option.memory + '<br/>' + lang_chart_tip.memory + '</div>'
        }
        title += '<div class="graph-info-block">' + option.request_number + '<br/>'+lang_chart_tip.request_count+'</div>'

        title += '</div>';

        info += title;

        if (option.info) {
            info += '<div class="graph-tooltip-content">' +
                '<div class="graph-tooltip-text">' + option.info.name + '</div>' +
                '<div class="graph-tooltip-text">' +
                '<div class="graph-tooltip-left">' + lang_chart_tip.start_time + ':</div>' +
                '<div class="graph-tooltip-right">' + option.info.start_time + 'ms</div>' +
                '</div>' +
                '<div class="graph-tooltip-text">' +
                '<div class="graph-tooltip-left">' + lang_chart_tip.time_range + ':</div>' +
                '<div class="graph-tooltip-right">' + option.info.duration + 'ms</div>' +
                '</div>' +
                '</div>';
        }

        info += '</div>';

        tooltip.append(line);
        tooltip.append(info);

        return tooltip;
    }

    /**
     * 根据鼠标位置计算弹窗信息
     * @param eLeft
     * @param range
     * @returns {{left: number, time: number, cpu: *, memory: *}}
     */
    TsbGraph.prototype.queryIndexByPosition = function (eLeft, range) {
        var _self = this;

        var time = Math.round(_self.min + (_self.max - _self.min) * eLeft / range);
        var left = time / (_self.max - _self.min) * range;

        var cpu = null,
            memory = null;

        for (var item in _self.data.current_cpu) {
            if (time <= item) {
                cpu = _self.data.current_cpu[item];
                break;
            }
        }
        for (var item in _self.data.current_memory) {
            if (time <= item) {
                memory = _self.data.current_memory[item];
                break;
            }
        }

        return {
            time: time,
            cpu: cpu,
            memory: memory
        }

    }

    /**
     * 根据鼠标位置获取请求数
     * @param eLeft
     * @param range
     * @returns {number}
     */
    TsbGraph.prototype.queryRequestsByPosition = function (eLeft, range) {
        var _self = this;
        var time = Math.round(_self.min + (_self.max - _self.min) * eLeft / range),
            requests = _self.data.tree.request || [],
            include_requests = [];

        for (var i = 0, l = requests.length; i < l; i++) {
            if (time > requests[i].start_time && time < (requests[i].start_time + requests[i].duration)) {
                include_requests.push(requests[i]);
            }
        }

        return include_requests;
    }

    $.fn.tsbGraph = function (data) {
        return this.each(function () {
            return new TsbGraph($(this), data).init();
        });
    }

})(this, jQuery);