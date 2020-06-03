import React from 'react';
import MediaQuery from 'react-responsive';

class Pieces extends React.Component{
    render(){
        return(
            <h1>&#9812;&#9813;&#9814;&#9815;&#9816;&#9822;&#9821;&#9820;&#9819;&#9818;</h1>
        ); 
    }
}
class Title extends React.Component{
    render(){
        return(
            <h2>Buffalo Scholastic Chess League</h2>
        );
    }
}
class HeadImage extends React.Component{
    render(){
        return(
            <div>
            <MediaQuery maxDeviceWidth = {800}>
                <img src={require('../images/Mheader.png')} alt="Header Image."></img>
            </MediaQuery>
            <MediaQuery minDeviceWidth = {801}>
                <img src={require('../images/header.png')} alt="Header Image."></img>
            </MediaQuery>
            </div>
        );
    }
}
export class Header extends React.Component{
    render(){
        if(this.props.state.local !== "About"){
            return(
                <div>
                    <Pieces />
                    <Title />
                </div>
            );    
        } else{
           return(
                <div>
                    <Pieces />
                    <Title />
                    <HeadImage />
                </div>
            ); 
        }
    }
}