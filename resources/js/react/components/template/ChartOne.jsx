import React, { useState, useEffect, memo } from 'react'
import ReactApexChart from 'react-apexcharts'
import { getTopDay, getTopWeek } from '../../api/dashboard'

const colors = ['#7BD3EA', '#A1EEBD', '#FF8080', '#E26EE5', '#FFB534']
const getCategories = groupBy => {
    if (groupBy === 'day') {
        return new Array(new Date().getDate()).fill(0).map((_, i) => {
            if (i == 1) return i + 1 + 'st'
            else if (i == 2) return i + 1 + 'nd'
            else if (i == 3) return i + 1 + 'rd'
            else return i + 1 + 'th'
        })
    } else {
        return new Array(8)
            .fill(0)
            .map((_, i) => {
                var dt = new Date(new Date().getFullYear(), 0, 1)
                return Math.ceil(((new Date() - dt) / 86400000 + dt.getDay() + 1) / 7) - i
            })
            .reverse()
    }
}
const options = (groupBy, max) => {
    return {
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'left',
        },
        stroke: {
            curve: 'smooth',
        },
        dataLabels: {
            enabled: false,
        },
        colors: colors,
        chart: {
            fontFamily: ', sans-serif',
            height: 335,
            type: 'area',
            dropShadow: {
                enabled: true,
                color: '#623CEA14',
                top: 10,
                blur: 4,
                left: 0,
                opacity: 0.1,
            },

            toolbar: {
                show: false,
            },
        },
        labels: {
            show: false,
            position: 'top',
        },
        grid: {
            xaxis: {
                lines: {
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: true,
                },
            },
        },
        markers: {
            size: 5,
            strokeColors: colors,
            strokeWidth: 3,
            strokeOpacity: 0.9,
            strokeDashArray: 0,
            fillOpacity: 1,
            discrete: [],
            hover: {
                size: undefined,
                sizeOffset: 5,
            },
        },
        xaxis: {
            type: 'category',
            categories: getCategories(groupBy),
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            title: {
                style: {
                    fontSize: '0px',
                },
            },
            min: 0,
        },
    }
}

const ChartOne = () => {
    const [data, setData] = useState({})
    const [groupBy, setGroupBy] = useState('day')
    const [top, setTop] = useState(3)
    const [isActive, setIsActive] = useState(1)

    const fetchData = () => {
        if (groupBy === 'day') {
            getTopDay(top).then(res => {
                setData(res.data)
            })
        } else if (groupBy === 'week') {
            getTopWeek(top).then(res => {
                setData(res.data)
            })
        }
    }

    useEffect(() => {
        fetchData()
    }, [groupBy, top])

    return (
        <div className="col-span-8 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark ">
            <div className="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap">
                <div className="flex w-full flex-wrap gap-3 sm:gap-5">
                    {data?.series?.map((v, i) => (
                        <div className="flex min-w-47.5" key={i + colors[i]}>
                            <span
                                className="mr-2 mt-1 flex h-4 w-full max-w-4 items-center justify-center rounded-full border border-primary"
                                style={{ borderColor: colors[i] }}
                            >
                                <span
                                    className="block h-2.5 w-full max-w-2.5 rounded-full bg-primary"
                                    style={{ backgroundColor: colors[i] }}
                                ></span>
                            </span>
                            <div className="w-full">
                                <p
                                    className="font-semibold text-primary"
                                    style={{ color: colors[i] }}
                                >
                                    Total <strong>{v.name}</strong> Revenue
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
                <div className="mr-4 flex w-full max-w-45 items-center justify-end">
                    <span className="pr-2 font-semibold">Top</span>
                    <select
                        className="relative z-20 inline-flex appearance-none border-none bg-transparent py-1 pl-3 pr-8 text-sm font-medium shadow-none outline-none focus:border-gray-300"
                        onChange={e => setTop(e.target.value)}
                        value={top}
                    >
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="7">7</option>
                    </select>
                    <div className="inline-flex items-center rounded-md bg-whiter p-1.5 dark:bg-meta-4">
                        <button
                            value={'day'}
                            onClick={() => {
                                setGroupBy('day')
                                setIsActive(1)
                            }}
                            className={`rounded px-3 py-1 text-xs font-medium text-black hover:bg-white hover:shadow-card dark:bg-boxdark dark:text-white dark:hover:bg-boxdark ${
                                isActive == 1 ? 'bg-white  shadow-card dark:bg-boxdark' : ''
                            }`}
                        >
                            Day
                        </button>
                        <button
                            value={'week'}
                            onClick={() => {
                                setGroupBy('week')
                                setIsActive(2)
                            }}
                            className={`rounded px-3 py-1 text-xs font-medium text-black hover:bg-white hover:shadow-card dark:text-white dark:hover:bg-boxdark ${
                                isActive == 2 ? 'bg-white  shadow-card dark:bg-boxdark' : ''
                            }`}
                        >
                            Week
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <div id="chartOne" className="-ml-5">
                    {data?.series ? (
                        <>
                            <ReactApexChart
                                options={options(groupBy)}
                                series={data.series}
                                type="line"
                                height={350}
                            />
                            <p className="flex w-full justify-center text-sm font-medium">
                                {data.range.start} - {data.range.end}
                            </p>
                        </>
                    ) : null}
                </div>
            </div>
        </div>
    )
}

export default memo(ChartOne)
