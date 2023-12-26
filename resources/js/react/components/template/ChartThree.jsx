import React, { useState } from 'react'
import ReactApexChart from 'react-apexcharts'
import { useEffect } from 'react'
import { productRevenueByCategory } from '../../api/dashboard.js'

const ChartThree = () => {
    const [data, setData] = useState([])
    const [labelList, setLabelList] = useState([])
    const [groupBy, setGroupBy] = useState('day')

    const fetchDate = () => {
        productRevenueByCategory(groupBy).then(res => {
            setLabelList(res.data.map(i => i.name))
            setData(res.data.map(i => Math.round(i.totalRevenue * 100) / 100))
        })
    }

    const getOptions = labelList => {
        return {
            chart: {
                type: 'donut',
            },
            colors: ['#10B981', '#375E83', '#259AE6', '#FFA70B'],
            labels: labelList,
            legend: {
                show: true,
                position: 'bottom',
            },

            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        background: 'transparent',
                    },
                },
            },
            dataLabels: {
                enabled: false,
            },
        }
    }

    useEffect(() => {
        fetchDate()
    }, [groupBy])

    return (
        <div className="col-span-4 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div className="mb-3 justify-between gap-4 sm:flex">
                <div>
                    <h5 className="text-xl font-semibold text-black dark:text-white">
                        Category Analytics{' '}
                    </h5>
                </div>
                <div>
                    <div className="relative z-20 inline-block">
                        <select
                            className="relative z-20 inline-flex appearance-none bg-transparent py-1 pl-3 pr-8 text-sm font-medium outline-none"
                            onChange={e => setGroupBy(e.target.value)}
                            value={groupBy}
                        >
                            <option value="day">Daily</option>
                            <option value="month">Monthly</option>
                            <option value="year">Yearly</option>
                        </select>
                    </div>
                </div>
            </div>

            <div className="mb-2">
                <div id="chartThree" className="mx-auto flex h-full justify-center">
                    {data.length > 0 ? (
                        <ReactApexChart
                            options={getOptions(labelList)}
                            series={data}
                            type="donut"
                        />
                    ) : (
                        <div className="mx-auto self-center">
                            <i>No Data</i>
                        </div>
                    )}
                </div>
            </div>
        </div>
    )
}

export default ChartThree
