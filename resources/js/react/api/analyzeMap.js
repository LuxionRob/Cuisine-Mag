import { instance } from './init'

export const getStores = () => {
    return instance.get('stores')
}
