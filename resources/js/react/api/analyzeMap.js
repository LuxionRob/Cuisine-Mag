import { instance } from './init'

export const getStores = () => {
    return instance.get('stores')
}

export const getStore = id => {
    return instance.get('stores/' + id)
}
