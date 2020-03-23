package com.ahmed.e_exam;

import androidx.appcompat.app.AppCompatActivity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.basgeekball.awesomevalidation.utility.RegexTemplate;
import com.google.android.material.bottomnavigation.BottomNavigationView;

public class MainActivity extends AppCompatActivity {
      //initialize variables
TextView TVlevels, TVdepts;
EditText etName, etAcademicNo, etEmail, etPassword, etConfirmPassword;
Button   btnRegister,btnLoginnow;
Spinner  spnLevels, spnDepts;

// defining two arrays to store levels and depts
String   Levels[]= {"select your level","FIRST LEVEL","SECOND LEVEL","THIRD LEVEL","FOURTH LEVEL" };
String   Depts []= {"select your department","GENERAL","SOFTWARE ENGINEERING","INFORMATION TECHNOLOGY","COMPUTER SCIENCE","INFORMATION SYSTEM"};

//before using the next variable you have to set this code ( implementation 'com.basgeekball:awesome-validation:2.0' ) in build gradle app file
AwesomeValidation awesomeValidation;
//ArrayAdapter <CharSequence> adapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //Assign Variables
        etName               =findViewById(R.id.etname);
        etAcademicNo         =findViewById(R.id.etacadnum);
        etEmail              =findViewById(R.id.etemail);
        spnLevels            =findViewById(R.id.spnlevels);
        //TVlevels          =findViewById(R.id.tvlevels);
        spnDepts             =findViewById(R.id.spndepts);
        //TVdepts           =findViewById(R.id.tvdepts);
        etPassword           =findViewById(R.id.etpass);
        etConfirmPassword    =findViewById(R.id.etconfrimpass);
        btnRegister          =findViewById(R.id.btnregister);
        btnLoginnow          =findViewById(R.id.btnloginnow);


//adapter = ArrayAdapter.createFromResource(this,R.array.Levels,android.R.layout.simple_spinner_dropdown_item);
//adapter = ArrayAdapter.createFromResource(this,R.array.Depts ,android.R.layout.simple_spinner_dropdown_item);

        // Define the array to a spinner as a dropdown list
        ArrayAdapter adp =new ArrayAdapter(this,android.R.layout.simple_spinner_item,Levels);
        adp.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        ArrayAdapter Adp =new ArrayAdapter(this,android.R.layout.simple_spinner_item,Depts);
        Adp.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        spnLevels.setAdapter(adp);
        spnDepts .setAdapter(Adp);

        spnLevels.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int position, long id)
            {
                if(position==0)
                {
                    TVlevels.setText("");
                }
                else
                {
                    TVlevels.setText(Levels[position]);
                    TVlevels.setTextColor(Color.BLACK);
                    TVlevels.setTextSize(18);
                }

            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });

        spnDepts.setOnItemSelectedListener (new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int position, long id)
            {
                if(position==0)
                {
                    TVdepts.setText("");
                }
                else
                {
                    TVdepts.setText(Depts[position]);
                    TVdepts.setTextColor(Color.BLACK);
                    TVdepts.setTextSize(18);
                }

            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });

        //initialize validation style
        awesomeValidation = new AwesomeValidation(ValidationStyle.BASIC);

        //add validation for name
        awesomeValidation.addValidation(this,R.id.etname, RegexTemplate.NOT_EMPTY ,R.string.Invalid_name);

        //add validation for email
        awesomeValidation.addValidation(this,R.id.etemail, Patterns.EMAIL_ADDRESS ,R.string.Invalid_email);

        //add validation for levels
        awesomeValidation.addValidation(this,R.id.spnlevels, RegexTemplate.NOT_EMPTY ,R.string.Incorrect_level);

        //add validation for Depts
        awesomeValidation.addValidation(this,R.id.spndepts, RegexTemplate.NOT_EMPTY ,R.string.Incorrect_Dept);

        //add validation for Academic No.
        awesomeValidation.addValidation(this,R.id.etacadnum,"[0-9]{16}$" ,R.string.Invalid_acadnum);

        //add validation for password
        awesomeValidation.addValidation(this,R.id.etpass,".{8,}" ,R.string.Invalid_password);

        //add validation for confirm password
        awesomeValidation.addValidation(this,R.id.etconfrimpass,R.id.etpass ,R.string.Invalid_confirm_password);

        //when click button register
        btnRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //check validation
                if (awesomeValidation.validate())
                {
                    //on success validation
                    Toast.makeText(getApplicationContext(), "Registered Successfully", Toast.LENGTH_SHORT).show();
                    //when click button register
                    Login();
                }
                else {Toast.makeText(getApplicationContext(), "Registration Failed",Toast.LENGTH_SHORT).show();}
            }
        });
        //when click button login now
        btnLoginnow.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view)
            {
            login_now();
            }
        });
}

  //two methods to open login activity
  public void  Login()
  {
    Intent intent = new Intent(this, com.ahmed.e_exam.LoginPage.class);
    startActivity(intent);
  }
  public void  login_now()
  {
        Intent intent = new Intent(this, com.ahmed.e_exam.LoginPage.class);
        startActivity(intent);
  }
}
