'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import { Header } from './pages/header';
import { Navigation} from './pages/navigation';
import { Schedule } from './pages/schedule';
import { History } from './pages/matchhistory';
import MediaQuery from 'react-responsive';

//====Building the body of the application.
class About extends React.Component{
    cacheMatches(){
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://www.BuffaloScholasticChessLeague.com/admin/scripts/getMatches.php");
        xhttp.send();    
        xhttp.onreadystatechange= function(){    
            if(xhttp.readyState===4 && xhttp.status===200){
                var ff = xhttp.response;        
                localStorage.setItem("MatchHistory", ff);        
            }                
        }    
    }
    cacheSchedule(){
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://www.BuffaloScholasticChessLeague.com/admin/scripts/getSchedule.php");
        xhttp.send();    
        xhttp.onreadystatechange= function(){    
            if(xhttp.readyState===4 && xhttp.status===200){
                var ff = xhttp.response;        
                localStorage.setItem("Schedule", ff);        
            }                
        }    
    }
    cacheData(){
        let today = new Date();
        let exp = new Date(today.getTime()+86400000);
        localStorage.setItem("Expire", exp.toDateString());
        this.cacheMatches();
        this.cacheSchedule();
    }
    render(){
        if(!localStorage.getItem("MatchHistory") || !localStorage.getItem("Schedule") || !localStorage.getItem("Expire")){
            this.cacheData();
        } else{
            let exp = new Date(localStorage.getItem("Expire"));
            let today = new Date();
            if(exp.getTime() < today.getTime()){
                this.cacheData();
            }
        }
        return(
            <div>
                <h3>About Us:</h3>
                {"We are a scholastic chess League working in partnership with local schools to provide a fun, safe,and engaging chess tournament experience."}
                <h4>All grade school players are welcome!</h4>
                {"This League is open to all students K-12. Teams can be based on school, but those who do not have enough players may partner with other teams, orbring in substitute players from other schools."}
                <h3>Contact Us:</h3>
                <p>Email:<a href="mailto:thebuffalochessassociation@gmail.com">TheBuffaloChessAssociation@gmail.com</a></p>
                <p>Phone: (716)622-4287</p>
            </div>
        );
    }
}
//====Building Chess Resources.
class Resources extends React.Component{

    render(){
        return (
            <div>
                Kids Play Chess:
                <br />
                <a href="http://www.kidsplaychess.club"><img src={require("./images/kpc.png")} alt="Kids Play Chess"></img></a>
                <br />
                Buffalo Chess Association:
                <br />
                <a href="http://www.buffalochessassociation.com"><img src={require("./images/bca.png")} id="bca"alt="Buffalo Chess Association"></img></a>
            </div>
        );
    }
}
//====Building Photos.
class Photos extends React.Component{
    render(){
        //localStorage.clear();
        return(
            <div>
                <h2>Photos.</h2>
                <p>This page is under construction, please check back soon.</p>
            </div>
        ); 
    }
}
//====Building Rules.
class Rules extends React.Component{
    render(){
    return (
        <div>
            Click <a href="./pdfs/chessrules.pdf" download>here</a> to download a pdf of the interscholastic chess rules.
        </div>
    );
    }
}
//====Building the Footer.
class Footer extends React.Component{
    render(){
        return (
            <div id="foot">
                <hr />
                <MediaQuery maxDeviceWidth={800}>
                    <img src={require('./images/Mfoot.png')} alt="Footer Image."></img>
                </MediaQuery>
                <MediaQuery minDeviceWidth={801}>
                    <img src={require('./images/foot.png')} alt="Footer Image."></img>
                </MediaQuery>
            </div>
            
        );
    }
}
//====Error Catch.
class Oops extends React.Component{
    render(){
        return<p>Oopsies.</p>;
    }
}
//=====Master Page.
class BSCL extends React.Component{
    constructor(props) {
        super(props);
        if(this.state==null){
            this.state = {
            local: "About",
            };
        }
        
        this.handler = this.handler.bind(this);
    }
    handler(l){
        this.setState({
            local: l
        });
    }
    render(){
        if(this.state.local === "About"){
            return(
                <div>
                   <Header state={this.state}/>
                   <Navigation handler={this.handler}/>
                   <About />
                   <Footer />               
                </div> 
            );
        }else if(this.state.local === "Schedule"){
            return(
                <div>
                    <Header state={this.state} />
                    <Navigation handler={this.handler}/>
                    <Schedule />
                    <Footer />
                </div>
            )
        }else if(this.state.local === "Match History"){
            return(
                <div>
                    <Header state={this.state} />
                    <Navigation handler={this.handler}/>
                    <History />
                </div>
            )
        }else if(this.state.local === "Chess Resources"){
            return(
                <div>
                    <Header state={this.state} />
                    <Navigation handler={this.handler}/>
                    <Resources />
                    <Footer />
                </div>
            )
        }else if(this.state.local === "Photos"){
            return(
                <div>
                    <Header state={this.state} />
                    <Navigation handler={this.handler}/>
                    <Photos />
                    <Footer />
                </div>
            )
        }else if(this.state.local === "Rules"){
            return(
                <div>
                    <Header state={this.state} />
                    <Navigation handler={this.handler}/>
                    <Rules />
                    <Footer />
                </div>
            )
        }else{
            return(
                <div>
                    <Header state={this.state}/>
                    <Navigation handler={this.handler}/>
                    <Oops />
                    <Footer />               
                </div> 
            );
        }
        
    }
}
//======Run the Jewels.
ReactDOM.render(
    <BSCL id="main"/>,
    document.getElementById('root')
); 
