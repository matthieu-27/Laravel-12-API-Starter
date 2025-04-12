import pandas as pd
import os
from datetime import datetime
import ftplib

def find_latest_file(directory, prefix):
    try:
        files = [f for f in os.listdir(directory) if f.startswith(prefix)]
        if not files:
            return None
        latest_file = max(
            files, key=lambda f: os.path.getctime(os.path.join(directory, f))
        )
        return os.path.join(directory, latest_file)
    except Exception as e:
        print(f"Error finding latest file: {e}")
        return None

def process_csv(file_path):
    try:
        filename = os.path.basename(file_path)
        date_part = filename.split("_")[1].split(".")[0]
        current_datetime = datetime.now().strftime("%Y-%m-%d_%H")

        # Use an absolute path for the backup directory
        script_dir = os.path.dirname(os.path.abspath(__file__))
        new_folder_path = os.path.join(script_dir, "backup")

        os.makedirs(new_folder_path, exist_ok=True)

        # Read the CSV file with UTF-8 encoding
        df = pd.read_csv(file_path, delimiter=";", encoding="utf-8")

        df["Qty"] = pd.to_numeric(df["Qty"], errors="coerce").fillna(0).astype(int)
        df["Poids"] = pd.to_numeric(df["Poids"], errors="coerce").fillna(0)
        df["Diametre"] = pd.to_numeric(df["Diametre"], errors="coerce").fillna(0)

        df["Prix"] = df.apply(calculate_price, axis=1)
        df["Prix"] = pd.to_numeric(
            df["Prix"].apply(lambda x: round(x, 2)), errors="coerce"
        )

        df["Qty"] = df["Qty"] - 2
        df = df[df["Qty"] > 1]

        df = df.drop(columns=["Poids", "Diametre"])

        current_hour = datetime.now().strftime("%H")
        new_filename = f"07ZR_{date_part}_{current_hour}_PRIMAPARTS.csv"
        new_file_path = os.path.join(new_folder_path, new_filename)

        df.to_csv(new_file_path, index=False, sep=";")

        upload_file_to_ftp(new_file_path)
    except Exception as e:
        print(f"Error processing CSV file: {e}")

def calculate_price(row):
    base_price = row["Prix"] + 1.45
    if row["Poids"] < 10:
        base_price += 5.6
    elif row["Poids"] >= 10 and row["Poids"] <= 15:
        base_price += 6.8
    elif row["Poids"] >= 15:
        base_price += 12.80

    if row["Diametre"] <= 16:
        base_price += 3.00
    elif row["Diametre"] == 17:
        base_price += 4.00
    elif row["Diametre"] >= 18:
        base_price += 6.00

    return base_price

def upload_file_to_ftp(file_path):
    ftp_host = "ftp.distri2b.com"
    ftp_user = "PRIMA5307"
    ftp_pass = "9B97Kzjc"
    ftp_path = "/"

    try:
        ftp = ftplib.FTP(ftp_host)
        ftp.login(user=ftp_user, passwd=ftp_pass)
        ftp.cwd(ftp_path)

        filename = os.path.basename(file_path)
        with open(file_path, "rb") as file:
            ftp.storbinary(f"STOR {filename}", file)
            print(f"Successfully uploaded {filename} to FTP server.")

        ftp.quit()
    except Exception as e:
        print(f"Failed to upload file to FTP server: {e}")

def main():
    # Use an absolute path to the sync directory
    script_dir = os.path.dirname(os.path.abspath(__file__))
    directory_to_scan = os.path.join(script_dir, "sync")
    latest_file_path = find_latest_file(directory_to_scan, "07ZR_")

    if latest_file_path:
        process_csv(latest_file_path)
    else:
        print("No file found with the prefix '07ZR_' in the specified directory.")

if __name__ == "__main__":
    main()