package model;

public class OutPersonDrink {

	private String time;
	private String boozeType;
	private String quantity;

	public OutPersonDrink() {

	}

	public OutPersonDrink(String time, String boozeType, String quantity) {
		super();
		this.time = time;
		this.boozeType = boozeType;
		this.quantity = quantity;
	}

	public String getTime() {
		return time;
	}

	public void setTime(String time) {
		this.time = time;
	}

	public String getBoozeType() {
		return boozeType;
	}

	public void setBoozeType(String boozeType) {
		this.boozeType = boozeType;
	}

	public String getQuantity() {
		return quantity;
	}

	public void setQuantity(String quantity) {
		this.quantity = quantity;
	}

}
