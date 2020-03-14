import React, {useState} from 'react'

export default function Login(props) {
    const [email, updateEmail] = useState("");
    const [password, updatePassword] = useState("");
    const [rememberMe, updateRememberMe] = useState(false);
    const [errors, updateErrors] = useState([]);

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.get('/airlock/csrf-cookie').then(response => {
           axios.post('/login', {
               email,
               password,
               rememberMe
           },{
           headers: { 'Content-Type': 'application/json' }
        }).then(res => {
            updateErrors([]);
            props.logIn(true);
        })
        .catch(err => {
            updateErrors(err.response.data.errors.email);
            });
        });
    }

    return (
      
            <div className="row justify-content-center">
                <h3 className="text-center">Welcome to Clear Applicant Tracking</h3>
                    
                        <div className="card col-md-6 col-lg-6" style={{backgroundColor: "#6B6570", color: "#EFF6E0"}}>
                            <div className="card-header text-center"><h5 className="m-0">Login</h5></div>
                                <div className="card-body">
                                    <form onSubmit={(e) => handleSubmit(e)}>
                                        <div className="row">
                                            <div className="input-field col s6">
                                                <label htmlFor="email">Email Address</label>
                                                <input id="email" type="email" className=" validate autocomplete" name="email" value={email} required 
                                                autoComplete="email" onChange={(e) => updateEmail(e.target.value)} autoFocus />
                                            </div>
                                        </div>
                                        <div className=" row">
                                            <div className="input-field col s6">
                                                <label htmlFor="password">Password</label>
                                                <input id="password" type="password" className="validate autocomplete" value={password} 
                                                onChange={(e) => updatePassword(e.target.value)} name="password" required autoComplete="current-password" />
                                                <span className="invalid-feedback" role="alert">
                                                </span>
                                            </div>
                                        </div>
                                        <div className="text-center mb-3">
                                            <strong className="text-info ">{errors && errors.map((error) => error)}</strong>
                                        </div>
                                        <div className="row">
                                            <div className="form-check mx-auto">
                                                <label className="form-check-label" htmlFor="remember">
                                                    <input type="checkbox" name="remember" id="remember" onClick={() => updateRememberMe(!rememberMe)} value={rememberMe}  />
                                                    <span>Remember Me</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div className="row">
                                            <div className="mx-auto">
                                                <button type="submit" className="btn waves-effect waves-light">
                                                    Login
                                                </button>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="mx-auto">
                                
                                    <a style={{color: "#EFF6E0"}} href="/password/reset">
                                       Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
        </div>
    
    )
}
