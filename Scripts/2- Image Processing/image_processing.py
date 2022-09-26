# -*- coding: utf-8 -*-
"""Image processing

Automatically generated by Colaboratory.

Original file is located at
    https://colab.research.google.com/drive/1nXsDIUe8FAIsP-YNE9JpwaRzBlf2ERkQ
"""

!pip install pydicom

import matplotlib.pylab as plt
from pydicom import dcmread
import pydicom as PDCM
import numpy as np
from skimage.transform import resize
import os
import matplotlib.pylab as plt
import cv2 
import pandas as pd
from pandas import ExcelFile,ExcelWriter

"""#**Convert from dicom files to jpg files**

**create patients empty folders after taking a sample of dicom files in each patient folder manually**
"""

#DataPath='/content/drive/MyDrive/Breast Cancer/manifest-1653094637718/QIN-BREAST'
DataPath='/content/drive/MyDrive/Breast Cancer2/manifest-1653094637718/QIN-BREAST'
for foldername in os.listdir(DataPath):
  patientID=foldername[-2:]
  directory='QIN-BREAST-01-00'+str(patientID)
  Output_Folder=os.path.join('/content/drive/MyDrive/QIN-Breast',directory)
  os.mkdir(Output_Folder)

"""**create new data folder, this folder will has patients folders with output jpg images**"""

directory='QIN-Breast Data'
path=os.path.join('/content/drive/MyDrive',directory)
os.mkdir(path)

def Dicom_to_Image(Path):
    DCM_Img = PDCM.read_file(Path)

    rows = DCM_Img.get(0x00280010).value #Get number of rows from tag (0028, 0010)
    cols = DCM_Img.get(0x00280011).value #Get number of cols from tag (0028, 0011)

    Instance_Number = int(DCM_Img.get(0x00200013).value) #Get actual slice instance number from tag (0020, 0013)

    Window_Center = int(DCM_Img.get(0x00281050).value) #Get window center from tag (0028, 1050)
    Window_Width = int(DCM_Img.get(0x00281051).value) #Get window width from tag (0028, 1051)

    Window_Max = int(Window_Center + Window_Width / 2)
    Window_Min = int(Window_Center - Window_Width / 2)

    if (DCM_Img.get(0x00281052) is None):
        Rescale_Intercept = 0
    else:
        Rescale_Intercept = int(DCM_Img.get(0x00281052).value)

    if (DCM_Img.get(0x00281053) is None):
        Rescale_Slope = 1
    else:
        Rescale_Slope = int(DCM_Img.get(0x00281053).value)

    New_Img = np.zeros((rows, cols), np.uint8)
    Pixels = DCM_Img.pixel_array

    for i in range(0, rows):
        for j in range(0, cols):
            Pix_Val = Pixels[i][j]
            Rescale_Pix_Val = Pix_Val * Rescale_Slope + Rescale_Intercept

            if (Rescale_Pix_Val > Window_Max): #if intensity is greater than max window
                New_Img[i][j] = 255
            elif (Rescale_Pix_Val < Window_Min): #if intensity is less than min window
                New_Img[i][j] = 0
            else:
                New_Img[i][j] = int(((Rescale_Pix_Val - Window_Min) / (Window_Max - Window_Min)) * 255) #Normalize the intensities

    return New_Img, Instance_Number

def Convert(folderPath):
  patientID=folderPath[-2:]
  directory='QIN-BREAST-01-00'+str(patientID)
  Output_Folder=os.path.join('/content/drive/MyDrive/QIN-Breast Data',directory)
  os.mkdir(Output_Folder)
  ListOfimages=[]
  images = []
  count=1
  for image in os.listdir(folderPath):
    imgPath=os.path.join(folderPath, image)
    Output_Image, Instance_Number = Dicom_to_Image(imgPath)
    cv2.imwrite(Output_Folder + '/' + str(count).zfill(2) + '.jpg', Output_Image)
    count+=1

"""**convert dicom files from old data folder to jpg images in new data folder by call Convert function**"""

dataPath='/content/drive/MyDrive/QIN-Breast'
for folderName in os.listdir(dataPath):
  Convert(os.path.join(dataPath,folderName))

"""#**Crop, resize and set X and y**

**read data labels**
"""

df = pd.read_excel("/content/drive/MyDrive/Data labels/QIN-Breast_TreatmentResponse(2014-12-16).xlsx" , header = 0)
df["Response"] = df ["Response"].map({"pCR": 1 , "non-pCR" : 0})
New_df = df["Response"]

"""*   crop and resize images
*   take all 30 images from each patient folder in X
*   take labels in y

"""

def load_data(folder):
    Images = []
    Y=[]
    for i in range(len(New_df)):
      patient=df.iloc[i,0]
      patientFolder=os.path.join(folder,patient)
      for img in os.listdir(patientFolder):
        if img is not None:
          img_file=cv2.imread(os.path.join(patientFolder,img), cv2.IMREAD_GRAYSCALE)
          #img_file=cv2.imdecode(np.fromfile(Path,dtype=np.uint8), cv2.IMREAD_GRAYSCALE)
          img_file=img_file[200:355,122:386]
          img_file=cv2.resize(img_file,(200,200))
          Images.append(img_file)
          Y.append(New_df.iloc[i])
    return Images,Y
x,y = load_data('/content/drive/MyDrive/QIN-Breast Data')

"""**save X and y using pickle in folders name X and y**"""

import pickle

pickle_out = open('/content/drive/MyDrive/Graduation Project/X.pickle','wb')
pickle.dump(x,pickle_out)
pickle_out.close()

pickle_out = open('/content/drive/MyDrive/Graduation Project/y.pickle','wb')
pickle.dump(y,pickle_out)
pickle_out.close()