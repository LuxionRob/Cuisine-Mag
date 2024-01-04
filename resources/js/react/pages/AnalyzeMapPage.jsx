import { ControlMap, HeatMap, InterpolateRevenue, MapLegend, RoadMap } from '../components'
import { MapContainer, Marker, Polygon, Popup, TileLayer } from 'react-leaflet'
import { convex, interpolate } from '@turf/turf'
import { getDensity, getRevenueFromLocation, getRoad, getStore, getStores } from '../api/analyzeMap'
import { useEffect, useState } from 'react'

import Leaflet from 'leaflet'

export default function AnalyzeMapPage() {
    const corner1 = Leaflet.latLng(10.35, 106.13)
    const corner2 = Leaflet.latLng(11.3, 107.05)
    const maxBounds = Leaflet.latLngBounds(corner1, corner2)
    const bounds = [
        [10.35, 106.33],
        [11.2, 107.05],
    ]
    const [stores, setStores] = useState([])
    const [interpolateRevenue, setInterpolateRevenue] = useState()
    const [pointsAroundStore, setPointsAroundStore] = useState({})
    const [heatPoints, setHeatPoints] = useState([])
    const [heatMapShow, setHeatMapShow] = useState(true)
    const [roadShow, setRoadShow] = useState(true)
    const [shopShow, setShopShow] = useState(true)
    const [interpolateShow, setInterpolateShow] = useState(true)
    const [roads, setRoads] = useState({
        type: 'FeatureCollection',
        features: [],
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
            const polygon = convex(res.data.geo)
            setPointsAroundStore(polygon)
            return res
        } catch (error) {}
    }

    const fetchDensity = async () => {
        try {
            const firstRes = await getDensity(1, null)
            const lastPage = firstRes.data.lastPage

            const points = firstRes.data.geo.features.map(p => [
                p.geometry.coordinates[1],
                p.geometry.coordinates[0],
                p.properties.populationDensity / 6.0,
            ])

            setHeatPoints(n => [...n, ...points])

            let i = 2
            while (i <= lastPage) {
                await getDensity(i, null).then(res => {
                    const points = res.data.geo.features.map(p => [
                        p.geometry.coordinates[1],
                        p.geometry.coordinates[0],
                        p.properties.populationDensity / 6.0,
                    ])
                    setHeatPoints(n => [...n, ...points])
                })
                ++i
            }
        } catch (error) {}
    }

    const fetchRoad = async () => {
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

    const fetchInterpolate = () => {
        getRevenueFromLocation().then(res => {
            const interpolatedPoly = interpolate(res.data, 1000, {
                gridType: 'square',
                property: 'rate',
                units: 'meters',
                weight: 1,
            })
            setInterpolateRevenue(interpolatedPoly)
        })
    }

    useEffect(() => {
        fetchInterpolate()
        fetchStores()
        fetchRoad()
        fetchDensity()
    }, [])

    const handleMarkerClick = e => {
        fetchStore(e.target.options.data)
    }

    return (
        <MapContainer
            bounds={bounds}
            minZoom={9}
            maxBounds={maxBounds}
            scrollWheelZoom={true}
            className="h-96 w-full"
            zoomControl={false}
        >
            <TileLayer
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            {shopShow
                ? stores.map(store => (
                      <Marker
                          eventHandlers={{
                              click: handleMarkerClick,
                          }}
                          key={store.id}
                          data={store.id}
                          position={[store.y, store.x]}
                      ></Marker>
                  ))
                : null}
            {pointsAroundStore?.type && (
                <Polygon positions={pointsAroundStore.geometry.coordinates} />
            )}
            {roadShow ? <RoadMap roads={roads} /> : null}
            {heatMapShow ? <HeatMap points={heatPoints} /> : null}
            <ControlMap
                setHeatMapShow={setHeatMapShow}
                setRoadShow={setRoadShow}
                setShopShow={setShopShow}
                setInterpolateShow={setInterpolateShow}
            />
            <MapLegend />
            {interpolateRevenue?.type && interpolateShow ? (
                <InterpolateRevenue data={interpolateRevenue} />
            ) : null}
        </MapContainer>
    )
}
