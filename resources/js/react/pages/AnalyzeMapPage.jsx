import { MapContainer, Marker, Polygon, TileLayer } from 'react-leaflet'
import { getDensity, getRoad, getStore, getStores } from '../api/analyzeMap'
import { useEffect, useState } from 'react'

import { HeatMap } from '../components'
import Leaflet from 'leaflet'
import Polyc from '../components/Polyc'
import RoadMap from '../components/RoadMap'
import { convex } from '@turf/turf'

export default function AnalyzeMapPage() {
    const corner1 = Leaflet.latLng(10.35, 106.33)
    const corner2 = Leaflet.latLng(11.2, 107.05)
    const maxBounds = Leaflet.latLngBounds(corner1, corner2)
    const bounds = [
        [10.35, 106.33],
        [11.2, 107.05],
    ]
    const [stores, setStores] = useState([])
    const [pointsAroundStore, setPointsAroundStore] = useState({})
    const [heatPoints, setHeatPoints] = useState([])
    // const [toggleLayer, setToggleLayer] = useState(true)
    const [densityLastPage, setDensityLastPage] = useState(1)
    const [roads, setRoads] = useState({
        type: 'FeatureCollection',
        features: [],
    })
    const [poly, setPoly] = useState({
        type: 'Feature',
        properties: {},
        geometry: {
            type: 'Polygon',
            coordinates: [],
        },
    })

    const fetchStores = async () => {
        try {
            const res = await getStores()
            setStores(res.data)
            return res
        } catch (error) {}
    }

    const fetchStore = async id => {
        try {
            const res = await getStore(id)
            const polygon = convex(res.data)
            setPointsAroundStore(polygon)
            return res
        } catch (error) {}
    }

    const fetchDensity = async () => {
        try {
            let result = heatPoints
            const firstRes = await getDensity(1, null)

            const points = firstRes.data.geo.features.map(p => [
                p.geometry.coordinates[0],
                p.geometry.coordinates[1],
                p.properties.populationDensity / 6.0,
            ])

            setHeatPoints(n => [...n, ...points])

            new Array(firstRes.data.lastPage - 1).fill(0).map((e, i) =>
                getDensity(i + 2, null).then(res => {
                    const points = res.data.geo.features.map(p => [
                        p.geometry.coordinates[0],
                        p.geometry.coordinates[1],
                        p.properties.populationDensity / 6.0,
                    ])
                    setHeatPoints(n => [...n, ...points])
                }),
            )
        } catch (error) {}
    }

    const fecthRoad = async () => {
        try {
            const firstRes = await getRoad(1)
            const lastPage = firstRes.data.lastPage
            setRoads(firstRes.data.geo)

            let i = 2
            while (i <= lastPage) {
                setRoads((await getRoad(i)).data.geo)
                ++i
            }
        } catch (error) {}
    }

    // const fetchDensity_1 = async () => {
    //     try {
    //         const firstRes = await getDensity(1, null)
    //         const lastPage = firstRes.data.lastPage
    //         let polygon = convex(firstRes.data.geo)
    //         setPoly(polygon)

    //         let i = 2
    //         while (i <= lastPage) {
    //             console.log(i + ' / ' + lastPage)
    //             setPoly(convex((await getDensity(i)).data.geo))
    //             ++i
    //         }
    //     } catch (error) {}
    // }

    // useEffect(() => {
    //     fetchDensity_1()
    // }, [])

    useEffect(() => {
        fecthRoad()
    }, [])

    useEffect(() => {
        fetchStores()
    }, [])

    useEffect(() => {
        fetchDensity()
    }, [])

    const handleMarkerClick = e => {
        fetchStore(e.target.options.data)
    }

    // const handleClick = e => {
    //     e.preventDefault()
    //     setToggleLayer(!toggleLayer)
    //     console.log(toggleLayer)
    // }

    return (
        <>
            <MapContainer
                bounds={bounds}
                minZoom={9}
                maxBounds={maxBounds}
                scrollWheelZoom={true}
                className="h-96 w-full"
                zoomControl={false}
            >
                {/* <Polyc poly={poly} /> */}
                <TileLayer
                    attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                />
                {stores.map(store => (
                    <Marker
                        eventHandlers={{
                            click: handleMarkerClick,
                        }}
                        key={store.id}
                        data={store.id}
                        position={[store.y, store.x]}
                    ></Marker>
                ))}
                {pointsAroundStore?.type && (
                    <Polygon positions={pointsAroundStore.geometry.coordinates} />
                )}
                <HeatMap points={heatPoints} />
                <RoadMap roads={roads} />
            </MapContainer>
            {/* <button onClick={handleClick}>click</button> */}
        </>
    )
}
