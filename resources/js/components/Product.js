import axios from 'axios'
import React, {Component} from 'react'

class Product extends Component {
    constructor(props) {
        super(props)
        this.state = {
            product: [],
            small: '',
            cover: '',
            authors: [],
            showSpinner: true,
            status :false
        }

    }

    async componentDidMount() {

        const url = window.location.href
        const id = url.split("/").pop();
        const enpoint = process.env.MIX_APP_URL + 'api/product/' + id
        await axios.get(enpoint).then(response => {

            if(response.data.status) {
            const product = response.data.data
            this.setState({
                product: product,
                small: product.images.small,
                cover: product.images.cover,
                authors: product.authors,
                showSpinner: false,
                status : true
            })
            } else{
                this.setState({
                    showSpinner: false,
                    small:'',
                    cover : '',
                    authors:[],
                    product:[],
                    status : false
                })
            }
        })

    }

    render() {
        const {product, images, small, cover, authors, showSpinner,status} = this.state
        return (

            (showSpinner) ?
                <div id="preloader">
                    <div className="preloader_div"></div>
                </div>
                :
                <div className="container">
                    {
                        (!status) ?
                            <p>Product Not Found</p>
                            :
                            <div className="row product-details">

                                <div className="col-md-6 img-div">
                                    <img src={small + '?token='+process.env.MIX_API_TOKEN} alt=""/>

                                </div>
                                <div className="col-md-6">


                                    <div className="product-description">
                                <span className={'product-type'}>{product.product_type} <a
                                    className="button is-primary btn-success"
                                    href={'/'}
                                >
                                <strong>Back to Listing</strong>
                            </a></span>
                                        <h3>{product.title}</h3>
                                        <p dangerouslySetInnerHTML={{__html: product.tagline}}></p>
                                    </div>


                                    <div className="product-configuration">

                                        <div className="cable-config">
                                            <div>
                                                <label className="label-color">Category : </label>
                                                {product.category}
                                            </div>
                                            <div>
                                                <label className="label-color">Pages : </label>
                                                {product.pages}
                                            </div>

                                            <div>
                                                <label className="label-color">Publication Date : </label>
                                                {product.publication_date}
                                            </div>


                                            <div>
                                                <label className="label-color">Length : </label>
                                                {product.length}
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div className="col-md-12">
                                    <div className={"product-description"}>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className={"product-description"}>
                                        <div>
                                            <label className="label-color">Learn</label>
                                            <span dangerouslySetInnerHTML={{__html: product.learn}}></span>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className={"product-description"}>
                                        <div className={'features'}>
                                            <label className="label-color">Features</label>
                                            <span dangerouslySetInnerHTML={{__html: product.features}}></span>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className={"product-description"}>
                                        <label className="label-color">Description</label>
                                        <span dangerouslySetInnerHTML={{__html: product.description}}></span>
                                    </div>
                                </div>

                                {
                                    (authors.length > 0)
                                        ?
                                        authors.map((author, authorKey) => (
                                            <div className={"col-md-6"}>
                                                <div>
                                                    <label className="label-color">Name : </label> {author.name}
                                                </div>
                                                <div>
                                                    <label className="label-color">About : </label>
                                                    <span dangerouslySetInnerHTML={{__html: author.about}}></span>
                                                </div>
                                            </div>

                                        ))

                                        :
                                        <p>No Authors</p>
                                }

                            </div>

                    }
                </div>
        )
    }
}

export default Product
