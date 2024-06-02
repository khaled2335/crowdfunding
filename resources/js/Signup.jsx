import React from "react";
import "./Signup.css";
import google from "./img/icons8-google.svg";
import facebook from "./img/devicon_facebook.svg";
function Signup() {
  return (
    <>
      <section className="login column col-12 overflow-hidden position-relative">
        <div className="inp input1 col-11 col-lg-3 col-md-6 col-sm-11">
          <h2 className="w-100">Sign Up</h2>
        </div>
        <div className="inp input2 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="text" placeholder="Name" />
        </div>
        <div className="inp input2 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="email" placeholder="Email" />
        </div>
        <div className="inp input3 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="password" placeholder="password" />
        </div>
        <div className="inp  input3  col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="password" placeholder="Re-enter Password" />
        </div>
        <div className="inp input5 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="submit" value="Sign Up" />
        </div>
        <div className="inp input6 col-11 col-lg-3 col-md-6 col-sm-11">
          <span>or :</span>
        </div>
        <div className="inp input7 col-11 col-lg-3 col-md-6 col-sm-11">
          <img src={google} alt="google" />
          <input type="submit" value="Google" />
        </div>
        <div className="inp input8 col-11 col-lg-3 col-md-6 col-sm-11">
          <img src={facebook} alt="facebook" />
          <input type="submit" value="Continue with Facebook" />
        </div>
      </section>
    </>
  );
}

export default Signup;
