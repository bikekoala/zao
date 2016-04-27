// 加载数据
var weiboData;
$.ajax({  
    url: 'http://zaoaoaoaoao.com/static/module/echarts/weibo.json',
    async: false,
    dataType: 'json',
    success: function drawChart(data) {
        weiboData = data.map(function (serieData, idx) {
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
    }
});

// echarts 配置
var option = { 
    baseOption: {
        title: {
            text: '飞鱼人在这里',
            subtext: 'data from PM25.in',
            sublink: 'http://www.pm25.in',
            left: 'left',
            textStyle: {
                color: '#fff'
            }
        },
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

// 渲染地图
document.getElementsByTagName('body')[0].style.height = document.body.scrollHeight + 'px';
echarts.init(document.getElementById('canvas')).setOption(option);

// 用户下拉菜单
$('#user').on('mouseenter', function() {
    $('#user-tips').removeClass('hide');
}).on('mouseleave', function() {
    setTimeout(function() {
        $('#user-tips').addClass('hide');
    }, 100);
});
