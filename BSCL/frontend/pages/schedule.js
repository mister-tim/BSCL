import React from 'react';

export class Schedule extends React.Component{
    render(){
        let cached = localStorage.getItem("Schedule");
        console.log(cached);
        return <h3>{JSON.parse(cached)}</h3>;
    }
}