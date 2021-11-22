import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import ProjectList from './ProjectList'
import Product from "./Product";

class App extends Component {
    render () {
        return (
            <Router>
                <Routes>
                    <Route path="/" caseSensitive={false} element={<ProjectList />} />
                    <Route path="/product/:id" caseSensitive={false} element={<Product />} />
                </Routes>
            </Router>
    )
    }
}
ReactDOM.render(<App />, document.getElementById('app'))
