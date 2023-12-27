import CardFour from '../../components/template/CardFour.jsx'
import CardThree from '../../components/template/CardThree.jsx'
import CardTwo from '../../components/template/CardTwo.jsx'
import ChartOne from '../../components/template/ChartOne'
import ChartThree from '../../components/template/ChartThree'
import Order from '../../components/template/Order.jsx'

const ECommerce = () => {
    return (
        <div className="h-full overflow-y-scroll">
            <div className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-3 2xl:gap-7.5 ">
                <CardTwo />
                <CardThree />
                <CardFour />
            </div>

            <div className="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
                <ChartOne />
                <ChartThree />
            </div>
            <div className="mt-4">
                <Order />
            </div>
        </div>
    )
}

export default ECommerce
