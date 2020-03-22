import React, {useState} from 'react'

export default function Login(props) {
    const [email, updateEmail] = useState("");
    const [password, updatePassword] = useState("");
    const [remember, updateRemember] = useState(false);
    const [errors, updateErrors] = useState({});
    const emailRegex = RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

    const handleBlur = (e) => {
        switch(e.target.name){
            case 'email':
                e.target.value.length == 0 || emailRegex.test(e.target.value) ? updateErrors({...errors, email: ""}) : 
                updateErrors({...errors, email: "Invalid Email Address"});
            break;
            case 'password':
                e.target.value.length > 0 && e.target.value.length < 6 ?  
                updateErrors({...errors, password: "Password Must Be Minimum 6 Characters"}) : 
                updateErrors({...errors, password: ""});
            break;
            default:
            break;
        }
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!emailRegex.test(email)){
            updateErrors({...errors, email: "Invalid Email Address"});
        } else {updateErrors({...errors, email: ""});}

        if (password.length < 6){
            updateErrors({...errors, password: "Invalid Password"});
        } else {updateErrors({...errors, password: ""});}

        if (errors.email === "" && errors.password === "") {
            axios.get('/airlock/csrf-cookie').then(response => {
            axios.post('/login', {
                email,
                password,
                remember
            },{
            headers: { 'Content-Type': 'application/json' }
            }).then(res => {
                if (res.data.success) {
                updateErrors([]);
                props.logIn(true);
                }
            })
            .catch(err => {
                updateErrors(err.response.data);
                });
            });
        }
    }

    return (
            <div className="row justify-content-center">
                <h3 className="text-center">Welcome to Clear Applicant Tracking</h3>
                    <div className="card col-md-6 col-lg-6" style={{backgroundColor: "#6B6570", color: "#EFF6E0"}}>
                        <div className="card-header text-center"><h5 className="m-0">Login</h5></div>
                            <div className="card-body">
                                <form onSubmit={(e) => handleSubmit(e)} noValidate>
                                    <div className="row">
                                        <div className="input-field col s6">
                                            <label htmlFor="email">Email Address</label>
                                            <input id="email" type="email" className=" validate autocomplete" name="email" value={email}  
                                            autoComplete="email" onBlur={(e) => handleBlur(e)} onChange={(e) => updateEmail(e.target.value)} autoFocus />
                                            <div className="text-center text-warning"> {errors.email}</div>
                                        </div>
                                    </div>
                                    <div className=" row">
                                        <div className="input-field col s6">
                                            <label htmlFor="password">Password</label>
                                            <input id="password" minLength="6" type="password" className="validate autocomplete" value={password} 
                                            onChange={(e) => updatePassword(e.target.value)} onBlur={(e) => handleBlur(e)} name="password"  autoComplete="current-password" />
                                            <div className="text-center text-warning"> {errors.password}</div>
                                        </div>
                                    </div>
                                    <div className="text-center mb-3">
                                        <strong className="text-warning ">{errors.message}</strong>
                                    </div>
                                    <div className="row">
                                        <div className="form-check mx-auto">
                                            <label className="form-check-label" htmlFor="remember">
                                                <input type="checkbox" name="remember" id="remember" onClick={() => updateRemember(!remember)} value={remember}  />
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
