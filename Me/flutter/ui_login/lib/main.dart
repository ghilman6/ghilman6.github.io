import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:ui_login/auth/auth_serivces.dart';
import 'package:ui_login/auth/wrapper.dart';
import 'package:ui_login/constants.dart';

void main() => runApp(MyApp());

class MyApp extends StatelessWidget {
  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return StreamProvider.value(
      value: AuthServices.firebaseUserStream,
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'UI Login',
        theme: ThemeData(
          primaryColor: kPrimaryColor,
          scaffoldBackgroundColor: Colors.white,
        ),
        home: Wrapper(),
      ),
    );
  }
}