import { useState, useEffect } from "react"
import { getSeries } from "../servicios/getSeries"

const useSeries = (producto) => {
    const [buscando, setBuscando] = useState(false)
    const [series, setSeries] = useState([])

    function rellenarSeries() {
        setBuscando(true)
        getSeries(producto).then(series => {
            setSeries(series)
            setBuscando(false)
        })
    }

    useEffect(rellenarSeries, [producto])
    return {buscando, series}
}
export default useSeries