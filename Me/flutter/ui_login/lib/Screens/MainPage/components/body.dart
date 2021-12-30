// import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:ui_login/Screens/Login/components/background.dart';
import 'package:ui_login/Screens/SignUp/signup_screen.dart';
import 'package:ui_login/Screens/Welcome/welcome_screen.dart';
import 'package:ui_login/auth/auth_serivces.dart';
import 'package:ui_login/components/already_have_an_account_acheck.dart';
import 'package:ui_login/components/rounded_button.dart';

class Body extends StatelessWidget {
  // final FirebaseUser user;
  const Body({
    Key key,
  }) : super(key: key);
  @override
  Widget build(BuildContext context) {

    Size size = MediaQuery.of(context).size;
    return Background(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Text(
            "MAIN PAGE",
            style: TextStyle(fontWeight: FontWeight.bold),
          ),
          SizedBox(height: size.height * 0.03),
          // Text(
          //   user.uid,
          //   style: TextStyle(fontWeight: FontWeight.bold),
          // ),
          SvgPicture.asset(
            "assets/icons/stay-home.svg",
            height: size.height * 0.35,
          ),
          SizedBox(height: size.height * 0.03),
          RoundedButton(
            text: "SIGN OUT",
            press: () async {
              await AuthServices.signOut();
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) {
                    return WelcomeScreen();
                  },
                ),
              );
            },
          ),
          AlreadyHaveAnAccountCheck(
            press: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) {
                    return SignUpScreen();
                  },
                ),
              );
            },
          ),
        ],
      ),
    );
  }
}
