import React from 'react';

class Destination extends React.Component{
    handler = () =>{
        this.props.handler(this.props.value);
    }
    render(){
        return(
            <a href="#" onClick={() => this.handler()}>{this.props.value}</a>
        );
    }
}
export class Navigation extends React.Component{
    renderDestination(v){
        return <Destination value={v} handler={this.props.handler}/>;
    }
    render(){
        return(
            <h3>
                {this.renderDestination("Schedule")}
                {" "}-{" "} 
                {this.renderDestination("Match History")}
                {" "}-{" "} 
                {this.renderDestination("Chess Resources")}
                {" "}-{" "} 
                {this.renderDestination("Photos")}
                {" "}-{" "}
                {this.renderDestination("Rules")}
            </h3>
        );
    }
}