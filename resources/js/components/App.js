import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import Login from './Login';

function App() {
    const [loggedIn, setLoggedIn] = useState(false);

    const logout = () => {
            axios.post('/logout', {
            },{
            headers: { 'Content-Type': 'application/json' }
         }).then(res => {
            setLoggedIn(false);
         })
         .catch(err => {
            console.log(err);
        });
        
    } 
    return (
       
        <div>
             {loggedIn ?
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Dashboard</div>

                        <div className="card-body">You are logged in!</div>
                        <button className="btn waves-effect waves-light"onClick={() => logout()}>logout</button>
                    </div>
                </div>
            </div> : <Login logIn={setLoggedIn}/> }
        </div>
        
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
