import axios from 'axios'
import React, {Component} from 'react'
import ReactPaginate from 'react-paginate'

class ProjectList extends Component {
    constructor(props) {
        super(props)
        this.state = {
            projects: [],
            showSpinner: true,
            page: 1,
            limit: 8,
            pageCount: 0
        }
        this.handlePageClick = this.handlePageClick.bind(this);


    }

    componentDidMount() {
        this.getData(this.state.page)
    }

    /**
     * to handle react pagination page click event to fetch data accrodingly
     * @param e
     */
    handlePageClick = (e) => {
        const selectedPage = e.selected;

        const page = (selectedPage == 0) ? 1 : selectedPage + 1
        this.getData(page)

    }

    /**
     * fetch products listing date based on page number passed
     * @param page
     * @returns {Promise<void>}
     */
    async getData(page) {
        this.setState({
            showSpinner: true
        })
        const limit = this.state.limit

        let config = {
            params: {
                page: page,
                limit: limit
            },
        }

        const url = process.env.MIX_APP_URL + 'api/products'
        await axios.get(url, config).then(response => {
            this.setState({
                projects: response.data.data,
                showSpinner: false,
                pageCount: response.data.pageCount
            })
        })
    }

    render() {
        const {projects, showSpinner} = this.state
        return (
            <>

                <div className={"container"}>
                    {
                        (showSpinner) ?
                            <div id="preloader">
                                <div className="preloader_div"></div>
                            </div>
                            :
                            <>
                                <div className="row">
                                    {
                                        (projects.length > 0)
                                            ?
                                            projects.map((productData, productKey) => (

                                                <div className="card col-md-3" key={productData.id}>
                                                    <div className="card-image">
                                                        <figure className="image is-4by3">
                                                            <img
                                                                alt={'/assets/images/download.jpeg'}
                                                                src={productData.cover}></img>
                                                        </figure>
                                                    </div>
                                                    <div className="card-content">
                                                        <p className="title product-title">{productData.title}</p>
                                                        <div className="content">
                                                            {productData.caption}
                                                            <br></br>
                                                        </div>
                                                        <a className="button is-primary"
                                                           href={'product/' + productData.id}
                                                        >
                                                            <strong>More Details</strong>
                                                        </a>
                                                    </div>
                                                </div>
                                            ))

                                            :
                                            <p>No Products found</p>
                                    }
                                </div>
                            </>


                    }
                </div>
                <div className={"row pagination-block"}>
                    <div className={"col-md-12"}>
                        <ReactPaginate previousLabel={"prev"}
                                       nextLabel={"next"}
                                       breakLabel={"..."}
                                       breakClassName={"break-me"}
                                       pageCount={this.state.pageCount}
                                       marginPagesDisplayed={2}
                                       pageRangeDisplayed={3}
                                       disableInitialCallback={true}
                                       onPageChange={this.handlePageClick}
                                       containerClassName={"pagination"}
                                       subContainerClassName={"pages pagination"}
                                       activeClassName={"active"}/>
                    </div>
                </div>

            </>


        )
    }
}

export default ProjectList
