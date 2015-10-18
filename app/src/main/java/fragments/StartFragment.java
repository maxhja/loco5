package fragments;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.text.SimpleDateFormat;
import java.util.Calendar;

import model.Result;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.StatusLine;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.conn.ConnectTimeoutException;

import se.loco.app.R;
import se.loco.app.SearchFriendsActivity;
import utils.ConnectUtils;
import utils.Globals;
import utils.ResultParser;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.graphics.Typeface;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.Fragment;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.ProgressBar;
import android.widget.SeekBar;
import android.widget.SeekBar.OnSeekBarChangeListener;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ToggleButton;

public class StartFragment extends Fragment implements OnClickListener,
		OnSeekBarChangeListener, OnCheckedChangeListener {

	ToggleButton toggleBtnHomeHarty;
	String userId;
	String onParty;
	String percent = "1";
	SeekBar seekBar;
	ImageView imgAddBuddys;
	boolean saveFragment;
	SharedPreferences prefs;
	Editor edit;

	LocationManager lm;
	String provider;
	Location l;

	double lng;
	double lat;
//	TextView txtHome;

	ViewGroup viewGroup;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		View rootView = inflater.inflate(R.layout.start_fragment, container,
				false);

		return rootView;
	}

	@Override
	public void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		if (savedInstanceState != null) {

			saveFragment = true;

		}

	}

	@Override
	public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
		// TODO Auto-generated method stub

		// if (saveFragment) {

		userId = prefs.getString(Globals.userId, null);

		lm = (LocationManager) getActivity().getSystemService(
				Context.LOCATION_SERVICE);
		Criteria c = new Criteria();
		// criteria object will select best service based on
		// Accuracy, power consumption, response, bearing and monetary cost
		// set false to use best service otherwise it will select the default
		// Sim network
		// and give the location based on sim network
		// now it will first check satellite than Internet than Sim network
		// location
		provider = lm.getBestProvider(c, false);
		// now you have best provider
		// get location
		l = lm.getLastKnownLocation(provider);

		if (l != null) {
			// get latitude and longitude of the location
			lng = l.getLongitude();
			lat = l.getLatitude();
			// display on text view
		} else {
			lng = 0;
			lat = 0;
		}

		if (isChecked) {
			if (prefs.getString(Globals.onStart, null).equals(
					Globals.onStartYes)) {
				onParty = "0";
				new UpdateStatusAsyncTask().execute(userId, onParty,
						String.valueOf(lat), String.valueOf(lng));
			}
		} else {
			if (prefs.getString(Globals.onStart, null).equals(
					Globals.onStartYes)) {
				onParty = "1";
				new UpdateStatusAsyncTask().execute(userId, onParty,
						String.valueOf(lat), String.valueOf(lng));
			}
		}

	}

	@Override
	public void onSaveInstanceState(Bundle outState) {
		// TODO Auto-generated method stub
		super.onSaveInstanceState(outState);
	}

	@Override
	public void onActivityCreated(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onActivityCreated(savedInstanceState);

		initialize();

	}

	private void initialize() {
		// TODO Auto-generated method stub
		toggleBtnHomeHarty = (ToggleButton) getActivity().findViewById(
				R.id.toggle_btn_home_party);
//		viewGroup = (ViewGroup) getActivity().findViewById(
//				R.id.layout_start_fragment);
		toggleBtnHomeHarty.setOnCheckedChangeListener(this);
		seekBar = (SeekBar) getActivity().findViewById(R.id.sbPartyLevel);
		seekBar.setOnSeekBarChangeListener(this);
		imgAddBuddys = (ImageView) getActivity().findViewById(R.id.img_add_buddys);
//		txtHome = (TextView) getActivity().findViewById(R.id.txt_home);
		imgAddBuddys.setOnClickListener(this);
		prefs = PreferenceManager.getDefaultSharedPreferences(getActivity());
		edit = prefs.edit();

		Typeface custom_font = Typeface.createFromAsset(getActivity()
				.getAssets(), "Rajdhani-SemiBold.ttf");
//		viewGroup.setTypeface(custom_font);

	}

	@Override
	public void onProgressChanged(SeekBar seekBar, int progress,
			boolean fromUser) {
		// TODO Auto-generated method stub
		percent = Integer.toString(progress);

		if (progress < 1)
			seekBar.setProgress(1);

	}

	@Override
	public void onStartTrackingTouch(SeekBar seekBar) {
		// TODO Auto-generated method stub

	}

	@Override
	public void onStopTrackingTouch(SeekBar seekBar) {
		// TODO Auto-generated method stub
		userId = prefs.getString(Globals.userId, null);
		new LevelAsyncTask().execute(userId, percent);

	}

	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub

		switch (v.getId()) {
		case R.id.img_add_buddys:

			// Toast toast = Toast.makeText(getActivity(),
			// "SearchFriendsActivity", Toast.LENGTH_LONG);
			// toast.setGravity(Gravity.CENTER, 0, 0);
			// toast.show();

			Intent addBuddyIntent = new Intent(getActivity(),
					SearchFriendsActivity.class);
			startActivity(addBuddyIntent);
			break;
		}

	}

	public class UpdateStatusAsyncTask extends AsyncTask<String, Void, String> {

		String sendString;
		ProgressBar progressStart;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressStart = (ProgressBar) getActivity().findViewById(
					R.id.progressBar);
			progressStart.setVisibility(View.VISIBLE);
		}

		@Override
		// protected String doInBackground(Void... arg0) {
		protected String doInBackground(String... params) {

			// String id = myApplication.getId();

			StringBuilder builder = new StringBuilder();
			ConnectUtils connector = new ConnectUtils();
			HttpClient client = connector.getNewHttpClient();

			String result = "FAILED";
			String user_id = params[0];
			String on_party = params[1];
			String latitude = params[2];
			String longitude = params[3];

			// date

			Calendar c = Calendar.getInstance();
			SimpleDateFormat sdf = new SimpleDateFormat(Globals.dateTimeFormat);
			String date = sdf.format(c.getTime());

			// LOAD SERVER PREF

			try {
				sendString = "http://posdima.com/loco/changeStatus.php?id="
						+ URLEncoder.encode(user_id, "UTF-8") + "&on_party="
						+ URLEncoder.encode(on_party, "UTF-8") + "&date="
						+ URLEncoder.encode(date, "UTF-8") + "&latitude="
						+ URLEncoder.encode(latitude, "UTF-8") + "&longitude="
						+ URLEncoder.encode(longitude, "UTF-8")

				;
			} catch (UnsupportedEncodingException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}

			HttpGet httpGet = new HttpGet(sendString);

			try {
				HttpResponse response = client.execute(httpGet);
				StatusLine statusLine = response.getStatusLine();
				int statusCode = statusLine.getStatusCode();
				if (statusCode == 200) {
					HttpEntity entity = response.getEntity();
					InputStream content = entity.getContent();
					BufferedReader reader = new BufferedReader(
							new InputStreamReader(content));
					String line;
					while ((line = reader.readLine()) != null) {
						builder.append(line);
					}
					result = builder.toString();

				} else {

				}
			} catch (ConnectTimeoutException e) {

				e.printStackTrace();
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			}

			return result;

			//

		}

		@Override
		protected void onPostExecute(String jsonString) {
			super.onPostExecute(jsonString);
			// REMOVE DIALOG
			progressStart.setVisibility(View.INVISIBLE);

			try {

				ResultParser resultParser = new ResultParser();
				Result result = resultParser.getParsedResults(jsonString);

				if (result.getError().contains("sucess")
						&& result.getMessage().contains("Home")) {

					Toast toast = Toast.makeText(getActivity(), "Home",
							Toast.LENGTH_LONG);
					toast.setGravity(Gravity.CENTER, 0, 0);
					toast.show();

				} else if (result.getError().contains("sucess")
						&& result.getMessage().contains("Party")) {

					Toast toast = Toast.makeText(getActivity(), "Party",
							Toast.LENGTH_LONG);
					toast.setGravity(Gravity.CENTER, 0, 0);
					toast.show();

				}

				else if (result.getError().contains("failed")) {

					Toast toast = Toast.makeText(getActivity(),
							"Error retry !!", Toast.LENGTH_LONG);
					toast.setGravity(Gravity.CENTER, 0, 0);
					toast.show();

				} else {

				}

			} catch (Exception e) {

			}

		}
	}

	public class LevelAsyncTask extends AsyncTask<String, Void, String> {

		String sendString;
		ProgressBar progressLevel;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressLevel = (ProgressBar) getActivity().findViewById(
					R.id.progressBarLevel);
			progressLevel.setVisibility(View.VISIBLE);
			progressLevel.setClickable(false);
		}

		@Override
		// protected String doInBackground(Void... arg0) {
		protected String doInBackground(String... params) {

			// String id = myApplication.getId();

			StringBuilder builder = new StringBuilder();
			ConnectUtils connector = new ConnectUtils();
			HttpClient client = connector.getNewHttpClient();

			String result = "FAILED";
			String user_id = params[0];
			String percent = params[1];

			// date

			Calendar c = Calendar.getInstance();
			SimpleDateFormat sdf = new SimpleDateFormat(Globals.dateTimeFormat);
			String date = sdf.format(c.getTime());

			// LOAD SERVER PREF

			try {
				sendString = "http://posdima.com/loco/partyLevel.php?id="
						+ URLEncoder.encode(user_id, "UTF-8") + "&party_level="
						+ URLEncoder.encode(percent, "UTF-8") + "&date="
						+ URLEncoder.encode(date, "UTF-8");
			} catch (UnsupportedEncodingException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}

			HttpGet httpGet = new HttpGet(sendString);

			try {
				HttpResponse response = client.execute(httpGet);
				StatusLine statusLine = response.getStatusLine();
				int statusCode = statusLine.getStatusCode();
				if (statusCode == 200) {
					HttpEntity entity = response.getEntity();
					InputStream content = entity.getContent();
					BufferedReader reader = new BufferedReader(
							new InputStreamReader(content));
					String line;
					while ((line = reader.readLine()) != null) {
						builder.append(line);
					}
					result = builder.toString();

				} else {

				}
			} catch (ConnectTimeoutException e) {

				e.printStackTrace();
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			}

			return result;

			//

		}

		@Override
		protected void onPostExecute(String jsonString) {
			super.onPostExecute(jsonString);
			// REMOVE DIALOG
			progressLevel.setVisibility(View.GONE);

			ResultParser resultParser = new ResultParser();
			Result result = resultParser.getParsedResults(jsonString);

			if (result.getError().contains("sucess")) {

				Toast toast = Toast.makeText(getActivity(),
						result.getMessage(), Toast.LENGTH_LONG);
				toast.setGravity(Gravity.CENTER, 0, 0);
				toast.show();

			} else {
				Toast toast = Toast.makeText(getActivity(), "Error retry !!",
						Toast.LENGTH_LONG);
				toast.setGravity(Gravity.CENTER, 0, 0);
				toast.show();

			}

		}
	}

	@Override
	public void onResume() {
		// TODO Auto-generated method stub
		super.onResume();
		edit.putString(Globals.onStart, Globals.onStartYes);
		edit.commit();

	}

}
