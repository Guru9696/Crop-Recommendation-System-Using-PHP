import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
import joblib

# Load your dataset
data = pd.read_csv('crop_data.csv')

# Features and labels
X = data[['pH', 'rainfall', 'temperature', 'soil_type']]
y = data['crop']

# Convert categorical data to numerical data
X = pd.get_dummies(X, columns=['soil_type'])

# Split the data
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train the model
model = RandomForestClassifier()
model.fit(X_train, y_train)

# Save the model
joblib.dump(model, 'crop_recommendation_model.pkl')
