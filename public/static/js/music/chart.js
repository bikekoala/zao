option = {
    tooltip: {},
    grid: {
        top: '2%',
        right: '2%',
        bottom: '1%',
        left: '0',
        containLabel: true
    },
    xAxis: {
        type: 'category',
        boundaryGap: false,
        data: ['2004','2005','2006','2007','2008','2009','2010','2011','2012','2013','2014','2015','2016']
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name: '播放次数',
            type: 'line',
            smooth: true,
            itemStyle: {
                normal: {
                    color: 'rgba(249, 146, 149, 0.9)'
                }
            },
            lineStyle: {
                normal: {
                    color: 'rgba(249, 146, 149, 0.8)'
                }
            },
            data: eval('(' + document.getElementById('chart').getAttribute('data') + ')')
        }
    ]
};
echarts.init(document.getElementById('chart')).setOption(option);
