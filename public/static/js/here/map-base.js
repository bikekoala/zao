/**
 * 地图类
 */
$.maps = (function() {
    var Return = {
        draw: function(mode) {
            if ( ! mode) {
                mode = $('#user').attr('data-map-mode');
            }

            var api = {
                //world: 'http://zaoaoaoaoao.com/here/worldMapData',
                world: 'http://zaoaoaoaoao.com/static/module/echarts/weibo.json',
                personal: 'http://zaoaoaoaoao.com/here/personalMapData' 
            };

            $.ajax({
                url: api[mode],
                dataType: 'json'
            }).done(function(data) {
                var option;
                if ('personal' === mode) {
                    draw(getPersonalOption(data));
                }
                if ('world' === mode) {
                    draw(getWorldOption(data));
                }
            });
        }
    }

    var draw = function(option) {
        document.getElementsByTagName('body')[0].style.height = document.body.scrollHeight + 'px';
        echarts.init(document.getElementById('canvas')).setOption(option);
    }

    var getPersonalOption = function(mapData) {
        var convertData = function (data) {
            var res = [];
            for (var i = 0; i < data.length; i++) {
                var dataItem = data[i];
                var fromCoord = mapData['coord'][dataItem[0].name];
                var toCoord = mapData['coord'][dataItem[1].name];
                if (fromCoord && toCoord) {
                    res.push({
                        fromName: dataItem[0].name,
                        toName: dataItem[1].name,
                        coords: [fromCoord, toCoord]
                    });
                }
            }
            return res;
        };

        var planePath = 'path://M1705.06,1318.313v-89.254l-319.9-221.799l0.073-208.063c0.521-84.662-26.629-121.796-63.961-121.491c-37.332-0.305-64.482,36.829-63.961,121.491l0.073,208.063l-319.9,221.799v89.254l330.343-157.288l12.238,241.308l-134.449,92.931l0.531,42.034l175.125-42.917l175.125,42.917l0.531-42.034l-134.449-92.931l12.238-241.308L1705.06,1318.313z';
        var color = ['#a6c84c', '#ffa022', '#46bee9', '#a6c84c', '#ffa022', '#46bee9', '#a6c84c', '#ffa022', '#46bee9', '#a6c84c', '#ffa022', '#46bee9'];

        var series = [];
        mapData['data'].forEach(function (item, i) {
            series.push({
                type: 'lines',
                zlevel: 1,
                effect: {
                    show: true,
                    period: 6,
                    trailLength: 0.7,
                    color: '#fff',
                    symbolSize: 3
                },
                lineStyle: {
                    normal: {
                        color: color[i],
                        width: 0,
                        curveness: 0.2
                    }
                },
                data: convertData(item[1])
            },
            {
                type: 'lines',
                zlevel: 2,
                effect: {
                    show: true,
                    period: 6,
                    trailLength: 0,
                    symbol: planePath,
                    symbolSize: 15
                },
                lineStyle: {
                    normal: {
                        color: color[i],
                        width: 1,
                        opacity: 0.4,
                        curveness: 0.2
                    }
                },
                data: convertData(item[1])
            },
            {
                type: 'effectScatter',
                coordinateSystem: 'geo',
                zlevel: 2,
                rippleEffect: {
                    brushType: 'stroke'
                },
                label: {
                    normal: {
                        show: true,
                        position: 'left',
                        formatter: '{b}'
                    }
                },
                symbolSize: function (val) {
                    return val[2] / 8;
                },
                itemStyle: {
                    normal: {
                        color: color[i]
                    }
                },
                tooltip: {
                    formatter: function(dataItem) {
                        return '时间: ' + mapData['date'][dataItem.name] + '<br>' +
                               '地点: ' + mapData['address'][dataItem.name];
                    }
                },
                data: item[1].map(function (dataItem) {
                    return {
                        name: dataItem[1].name,
                        value: mapData['coord'][dataItem[1].name].concat([50])
                    };
                })
            });
        });

        return {
            backgroundColor: '#404a59',
            tooltip : {
                trigger: 'item'
            },
            geo: {
                map: 'china',
                roam: true,
                top: 10,
                bottom: 10,
                scaleLimit: {
                    min: 1,
                    max: 5
                },
                label: {
                    emphasis: {
                        show: false
                    }
                },
                itemStyle: {
                    normal: {
                        areaColor: '#323c48',
                        borderColor: '#111'
                    },
                    emphasis: {
                        areaColor: '#2a333d'
                    }
                }
            },
            series: series
        };
    }

    var getWorldOption = function(mapData) {
        var weiboData = mapData.map(function (serieData, idx) {
            var px = serieData[0] / 1000;
            var py = serieData[1] / 1000;
            var res = [[px, py]];
        
            for (var i = 2; i < serieData.length; i += 2) {
                var dx = serieData[i] / 1000;
                var dy = serieData[i + 1] / 1000;
                var x = px + dx;
                var y = py + dy;
                res.push([x, y, 1]);
        
                px = x;
                py = y;
            }
            return res;
        });

        return {
            baseOption: {
                backgroundColor: '#404a59',
                tooltip: {
                    trigger: 'item'
                },
                geo: {
                    map: 'china',
                    roam: true,
                    top: 10,
                    bottom: 10,
                    scaleLimit: {
                        min: 1,
                        max: 5
                    },
                    label: {
                        emphasis: {
                            show: false
                        }
                    },
                    itemStyle: {
                        normal: {
                            areaColor: '#323c48',
                            borderColor: '#111'
                        },
                        emphasis: {
                            areaColor: '#2a333d'
                        }
                    }
                },
                series: [
                    {
                        name: 'HERE',
                        type: 'scatter',
                        coordinateSystem: 'geo'
                    }
                ],
                timeline: {
                    autoPlay: true,
                    playInterval: 2000,
                    bottom: 5,
                    label: {
                        position: 'bottom',
                        normal: {
                            formatter: function(value, index) {
                                return value;
                            },
                            textStyle: {
                                color: 'rgba(180, 180, 180, 0.5)',
                            }
                        }
                    },
                    lineStyle: {
                        type: 'dashed',
                        color: 'rgba(150, 150, 150, 0.4)',
                    },
                    itemStyle: {
                        normal: {
                            color: 'rgba(128, 128, 128, 0.5)',
                            shadowColor: 'rgba(0, 0, 0, 0.5)',
                            shadowBlur: 10,
                            borderWidth: 10,
                            borderColor: 'rgba(200, 200, 200, 0.5)',
                        }
                    },
                    controlStyle: {
                        normal: {
                            color: 'rgba(180, 180, 180, 0.5)',
                            borderColor: 'rgba(140, 140, 140, 0.4)',
                        }
                    }, 
                    data: [
                        {
                            value: '2004',
                            tooltip: {
                                formatter: '111'
                            }
                        },
                        {
                            value: '2005',
                            tooltip: {
                                formatter: '222'
                            }
                        },
                        {
                            value: '2006',
                            tooltip: {
                                formatter: '333'
                            }
                        },
                    ]
                }
            },
            options: [
                {
                    series : [
                        {
                            name: '2004',
                            type: 'scatter',
                            coordinateSystem: 'geo',
                            symbolSize: 1,
                            large: true,
                            itemStyle: {
                                normal: {
                                    shadowBlur: 2,
                                    shadowColor: 'rgba(37, 140, 249, 0.8)',
                                    color: 'rgba(37, 140, 249, 0.8)'
                                }
                            },
                            data: weiboData[0]
                        }
                    ]
                },
                {
                    series : [
                        {
                            name: '2005',
                            type: 'scatter',
                            coordinateSystem: 'geo',
                            symbolSize: 1,
                            large: true,
                            itemStyle: {
                                normal: {
                                    shadowBlur: 2,
                                    shadowColor: 'rgba(14, 241, 242, 0.8)',
                                    color: 'rgba(14, 241, 242, 0.8)'
                                }
                            },
                            data: weiboData[1]
                        }
                    ]
                },
                {
                    series : [
                        {
                            name: '2006',
                            type: 'scatter',
                            coordinateSystem: 'geo',
                            symbolSize: 1,
                            large: true,
                            itemStyle: {
                                normal: {
                                    shadowBlur: 2,
                                    shadowColor: 'rgba(255, 255, 255, 0.8)',
                                    color: 'rgba(255, 255, 255, 0.8)'
                                }
                            },
                            data: weiboData[2]
                        }
                    ]
                },
            ]
        };
    }

    return Return;
})();
