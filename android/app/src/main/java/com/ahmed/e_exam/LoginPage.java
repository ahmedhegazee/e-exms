package com.ahmed.e_exam;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;

public class LoginPage extends AppCompatActivity {

    EditText etEmail, etPassword;
    Button btnLogin;

    AwesomeValidation awesomeValidation;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_page);

        etEmail           =findViewById(R.id.etemail) ;
        etPassword        =findViewById(R.id.etpass)  ;
        btnLogin          =findViewById(R.id.btnlogin);

        awesomeValidation = new AwesomeValidation(ValidationStyle.BASIC);

        awesomeValidation.addValidation(this,R.id.etemail, Patterns.EMAIL_ADDRESS ,R.string.Invalid_email);
        awesomeValidation.addValidation(this,R.id.etpass,".{8,}" ,R.string.Invalid_password);
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //check validation
                if (awesomeValidation.validate())
                {
                    //on success validation
                    Toast.makeText(getApplicationContext(), "Login  Successfully", Toast.LENGTH_SHORT).show();
                }
                else {Toast.makeText(getApplicationContext(), "Login Failed",Toast.LENGTH_SHORT).show();}
            }
        });
    }
}
