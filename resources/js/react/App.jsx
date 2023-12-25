import { Suspense, lazy, useEffect, useState } from 'react'
import { Route, Routes } from 'react-router-dom'
import { Toaster } from 'react-hot-toast'
import { BrowserRouter as Router } from 'react-router-dom'

import ECommerce from './pages/Dashboard/ECommerce.jsx'
import Loader from './common/Loader'
import routes from './routes'

const DefaultLayout = lazy(() => import('./layout/DefaultLayout.jsx'))

function App() {
    const [loading, setLoading] = useState(true)

    useEffect(() => {
        setTimeout(() => setLoading(false), 1000)
    }, [])

    return loading ? (
        <Loader />
    ) : (
        <>
            <Router>
                <Toaster
                    position="top-right"
                    reverseOrder={false}
                    containerClassName="overflow-auto"
                />
                <Routes>
                    <Route path="/dashboard" element={<DefaultLayout />}>
                        <Route index element={<ECommerce />} />
                        {routes.map((routes, index) => {
                            const { path, Component } = routes
                            return (
                                <Route
                                    key={index}
                                    path={path}
                                    element={
                                        <Suspense fallback={<Loader />}>
                                            <Component />
                                        </Suspense>
                                    }
                                />
                            )
                        })}
                    </Route>
                </Routes>
            </Router>
        </>
    )
}

export default App
