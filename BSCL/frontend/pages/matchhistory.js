import React from 'react';
import MediaQuery from 'react-responsive';
class DayButton extends React.Component{
    pickDay = () =>{
        this.props.pickDay(this.props.value);
        console.log(this.props.value);
    }
    render(){
        let cached = localStorage.getItem("MatchHistory");
        let parsed = JSON.parse(cached);
        return <button onClick={() => this.pickDay()}>{parsed[0][0][this.props.value][1]}</button>;
    }
}
class DaySelector extends React.Component{
    renderDays(s){
        let cached = localStorage.getItem("MatchHistory");
        let parsed = JSON.parse(cached);
        return parsed[0][s].map((day,index)=>this.renderDayButton(index))
    }
    renderDayButton(d){
        return <DayButton value={d} pickDay={this.props.pickDay} />;
    }
    render(){
        return (<div>
            {this.renderDays(this.props.value)}
        </div>)
    }
}
class Day extends React.Component{
    renderDay(){
        let cached = localStorage.getItem("MatchHistory");
        let parsed = JSON.parse(cached);
        return parsed[this.props.season+1][this.props.day].map((match) =>
            <table><tbody>{match.map((game) => 
            <tr>{game.map((data) =>
            <td id={data}>{data}</td>)}</tr>)}</tbody></table>
        );
    }
    render(){
        return(
            <div>
            <MediaQuery minDeviceWidth={800}>
                <div id="day">
                    {this.renderDay()}
                </div>
            </MediaQuery>
            <MediaQuery maxDeviceWidth={799}>
                <MediaQuery maxDeviceWidth={599}>
                    <div id="MSday">
                        {this.renderDay()}
                    </div>
                </MediaQuery>
                <MediaQuery minDeviceWidth={600}>
                    <div id="MLday">
                        {this.renderDay()}
                    </div>
                </MediaQuery>
            </MediaQuery>
        </div> 
        );
    }
}
class SeasonButton extends React.Component{
    pickSeason = () =>{
        this.props.pickSeason(this.props.value);
    }
    render(){
        let cached = localStorage.getItem("MatchHistory");
        let parsed = JSON.parse(cached);
        return <button onClick={() => this.pickSeason()}>{parsed[0][this.props.value][0][0]}</button>;
    }
}
class SeasonSelector extends React.Component{
    renderSeasonButton(s){
        return <SeasonButton value={s} pickSeason={this.props.pickSeason} />;
    }
    render(){
        let cached = localStorage.getItem("MatchHistory");
        let key = JSON.parse(cached);
        return key[0].map((season,index) => this.renderSeasonButton(index));
    }
}
export class History extends React.Component{
    constructor(props){
        super(props);
        if(this.state==null){
            this.state = {
                season: 0,
                day: 0,
            }
        }
        this.pickSeason = this.pickSeason.bind(this);
        this.pickDay = this.pickDay.bind(this);
    }
    pickSeason(s){
        this.setState({season:s, day:0});
    }
    pickDay(d){
        this.setState({day:d});
    }
    render(){
        return (
            <div>
                <SeasonSelector pickSeason={this.pickSeason}/>
                <DaySelector pickDay={this.pickDay} value={this.state.season}/>
                <Day day={this.state.day} season={this.state.season}/>
            </div>
        );
    }
}