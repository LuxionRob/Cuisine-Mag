import { instance } from './init'

export const getProductProfitByDayAndPrevDay = () => {
    return instance.get('products/profitByDayAndPrevDay')
}

export const getProductCountByDayAndPrevDay = () => {
    return instance.get('products/countByDayAndPrevDay')
}

export const getUserCountByDayAndPrevDay = () => {
    return instance.get('users/countByDayAndPrevDay')
}

export const getTopDay = top => {
    return instance.get('products/topProfitByDay', { params: { top } })
}

export const getTopWeek = top => {
    return instance.get('products/topProfitByWeek', { params: { top } })
}

export const productRevenueByCategory = groupBy => {
    return instance.get('products/productRevenueByCategory', {
        params: {
            groupBy,
        },
    })
}

export const getAllUser = () => {
    return instance.get('users')
}

export const deleteUser = id => {
    return instance.delete('users/' + id)
}

export const getUserById = id => {
    return instance.get('users/' + id)
}
