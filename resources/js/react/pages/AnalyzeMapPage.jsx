import { MapContainer, Marker, TileLayer, GeoJSON, Polygon } from 'react-leaflet'
import { getStores, getStore } from '../api/analyzeMap'
import { useEffect, useState } from 'react'
import { convex } from '@turf/turf'

export default function AnalyzeMapPage() {
    const position = [11.163194444396, 106.35736111134]
    const [stores, setStores] = useState([])
    const [pointsAroundStore, setPointsAroundStore] = useState({})
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

    useEffect(() => {
        fetchStores()
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
        </MapContainer>
    )
}
