package se.loco.app;

import utils.Globals;
import android.app.ActionBar;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.Gravity;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.Toast;

public class TransactionActivity extends Activity {

	SharedPreferences prefs;
	EditText tvWeight;
	Editor edit;

	@Override
	public void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.transaction_activity);
		ActionBar bar = getActionBar();
		bar.hide();

		prefs = PreferenceManager.getDefaultSharedPreferences(this);
		edit = prefs.edit();

		if (prefs.getString(Globals.userId, null) != null
				&& !prefs.getString(Globals.userId, null).isEmpty()) {
			Intent intent = new Intent(getApplicationContext(),
					TabsActivity.class);
			startActivity(intent);
		} else {

			Intent intent = new Intent(getApplicationContext(),
					MainActivity.class);
			startActivity(intent);

		}

	}

}