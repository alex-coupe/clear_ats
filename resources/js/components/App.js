import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import Login from './Login';

function App() {
    const [loggedIn, setLoggedIn] = useState(false);
    return (
       
        <div>
             {loggedIn ?
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Dashboard</div>

                        <div className="card-body">You are logged in!</div>
                    </div>
                </div>
            </div> : <Login /> }
        </div>
        
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
