import sys
import joblib
import logging
import pandas as pd

# Set up logging configuration
logging.basicConfig(filename='predict_crop.log', level=logging.DEBUG)

def main():
    try:
        if len(sys.argv) != 5:
            raise ValueError("Usage: predict_crop.py <soil_type> <pH> <rainfall> <temperature>")

        # Load the trained model
        model = joblib.load('crop_recommendation_model.pkl')

        # Parse command line arguments
        soil_type = sys.argv[1]
        pH = float(sys.argv[2])
        rainfall = float(sys.argv[3])
        temperature = float(sys.argv[4])

        # Mapping of soil types to one-hot encoded values
        soil_types = {'Loamy': [1, 0, 0], 'Clay': [0, 1, 0], 'Sandy': [0, 0, 1]}
        
        if soil_type in soil_types:
            input_data = [pH, rainfall, temperature] + soil_types[soil_type]
        else:
            raise ValueError("Unexpected soil type")

        # Convert input data to DataFrame with the correct column names to match the trained model's features
        input_df = pd.DataFrame([input_data], columns=['pH', 'rainfall', 'temperature', 'soil_type_Loamy', 'soil_type_Clay', 'soil_type_Sandy'])

        # Ensure the columns are in the correct order as expected by the model
        model_columns = model.feature_names_in_  # Get feature names from the trained model
        input_df = input_df[model_columns]  # Reorder the input data to match the model's expected feature order

        # Make prediction
        predicted_crop = model.predict(input_df)[0]

        # Output the prediction and log it
        print(predicted_crop)
        logging.debug(f"Predicted Crop: {predicted_crop}")
        logging.debug(f"Input Data: {input_data}")
        logging.debug(f"Expected Columns: {model_columns}")
        logging.debug(f"Reordered Input Data: {input_df}")

    except Exception as e:
        # Handle errors and log them
        print(f"Error: {str(e)}")
        logging.error(f"Error: {str(e)}")

if __name__ == "__main__":
    main()
