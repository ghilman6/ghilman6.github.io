import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:ui_login/Screens/Login/login_screen.dart';
import 'package:ui_login/Screens/SignUp/components/or_driver.dart';
import 'package:ui_login/Screens/SignUp/components/sosial_icon.dart';
import 'package:ui_login/auth/auth_serivces.dart';
import 'package:ui_login/components/already_have_an_account_acheck.dart';
import 'package:ui_login/components/rounded_button.dart';
import 'package:ui_login/components/rounded_input_field.dart';
import 'package:ui_login/components/rounded_password_field.dart';

import 'background.dart';

class Body extends StatelessWidget {
  final Widget child;

  const Body({Key key, @required this.child}) : super(key: key);
  
  @override
  Widget build(BuildContext context) {
    TextEditingController emailController = TextEditingController(text: "");
    TextEditingController passwordController  = TextEditingController(text: "");
    Size size = MediaQuery.of(context).size;
    return Background(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Text(
            "SIGNUP",
            style: TextStyle(fontWeight: FontWeight.bold),
          ),
          SvgPicture.asset(
            "assets/icons/signup.svg",
            height: size.height * 0.35,
          ),
          RoundedInputField(
            hintText: "Your Email",
            controller: emailController,
            onChanged: (value) {},
          ),
          RoundedPasswordField(
            controller: passwordController,
            onChanged: (value) {},
          ),
          RoundedButton(
            text: "SIGNUP",
            press: () async {
              await AuthServices.signUp(emailController.text, passwordController.text);
            },
          ),
          SizedBox(height: size.height * 0.03),
          AlreadyHaveAnAccountCheck(
            login: false,
            press: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) {
                    return LoginScreen();
                  },
                ),
              );
            },
          ),
          OrDivider(),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              SocalIcon(
                iconSrc: "assets/icons/facebook.svg",
                press: () {},
              ),
              SocalIcon(
                iconSrc: "assets/icons/twitter.svg",
                press: () {},
              ),
              SocalIcon(
                iconSrc: "assets/icons/google-plus.svg",
                press: () {},
              ),
            ],
          )
        ],
      ),
    );
  }
}
