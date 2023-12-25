import { instance } from './init'

export const getStores = () => {
    return instance.get('stores')
}

export const getStore = id => {
    return instance.get('stores/' + id)
}

export const getDensity = async (page, limit) => {
    return instance.get('density', { params: { page, limit } })
}

export const getTopFive = () => {
    return instance.get('products/topFiveProfit')
}
