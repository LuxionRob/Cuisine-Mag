import { MapContainer, Marker, TileLayer, Polygon } from 'react-leaflet'
import { useEffect, useState } from 'react'
import { convex } from '@turf/turf'

import { getStores, getStore, getDensity } from '../api/analyzeMap'
import { HeatMap } from '../components'

export default function AnalyzeMapPage() {
    const position = [11.163194444396, 106.35736111134]
    const [stores, setStores] = useState([])
    const [pointsAroundStore, setPointsAroundStore] = useState({})
    const [heatPoints, setHeatPoints] = useState([])
    const [densityLastPage, setDensityLastPage] = useState(1)

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

    useEffect(() => {
        fetchStores()
    }, [])

    useEffect(() => {
        fetchDensity()
    }, [])

    const handleMarkerClick = e => {
        fetchStore(e.target.options.data)
    }

    return (
        <MapContainer center={position} zoom={13} scrollWheelZoom={true} className="h-96 w-full">
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
        </MapContainer>
    )
}
