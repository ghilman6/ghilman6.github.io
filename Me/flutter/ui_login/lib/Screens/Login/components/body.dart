import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:ui_login/Screens/Login/components/background.dart';
import 'package:ui_login/Screens/SignUp/signup_screen.dart';
import 'package:ui_login/auth/auth_serivces.dart';
import 'package:ui_login/components/already_have_an_account_acheck.dart';
import 'package:ui_login/components/rounded_button.dart';
import 'package:ui_login/components/rounded_input_field.dart';
import 'package:ui_login/components/rounded_password_field.dart';


class Body extends StatelessWidget {
  const Body({
    Key key,
  }) : super(key: key);

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
            "LOGIN",
            style: TextStyle(fontWeight: FontWeight.bold),
          ),
          SizedBox(height: size.height * 0.03),
          SvgPicture.asset(
            "assets/icons/login.svg",
            height: size.height * 0.35,
          ),
          SizedBox(height: size.height * 0.03),
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
            text: "SIGNIN",
            press: () async {
              await AuthServices.signIn(emailController.text, passwordController.text);
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
