import sys

############################################################## convert to jpg
def Dicom_to_Image(Path):
    import numpy as np
    import pydicom as PDCM

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

def readImages(folderPath):
    import os
    import cv2

    X=[]
    for image in os.listdir( folderPath):
        imgPath=os.path.join(folderPath, image)
        Output_Image, Instance_Number = Dicom_to_Image(imgPath)
        img_file=Output_Image[200:355,122:386]
        img_file=cv2.resize(img_file,(200,200)) 
        X.append(img_file)
    return X

############################################################### Predict Function
def predict(path):
    import numpy as np
    from keras.models import load_model

    model1=load_model('F://Semester8//Bioserver//root//Website//model') #######################??????????????? path of model
    X_images= readImages(path)
    X_images=np.array(X_images)
    model=model1.predict(X_images)
    MeanPredict=[]
    sum0=0
    sum1=0
    for img in model:
        sum0+=img[0]
        sum1+=img[1]

    MeanPredict.append(sum0/len(model))
    MeanPredict.append(sum1/len(model))
    
    if np.argmax(MeanPredict) == 1:
        result=' PCR '
        acc=round(MeanPredict[1]*100)
    if np.argmax(MeanPredict) == 0:
        result=' nonPCR '
        acc=round(MeanPredict[0]*100)
    
    return result, acc

########################################################## take path from website and return result and accuracy
folderPath = sys.argv[1]

Result, Accuracy=predict(folderPath)


D={'first':Result, 'second': ' '+str(Accuracy)+' ' }
print(D)

'''
F://Semester8//Bioserver//root//Website//Test_Patients//P1
'''

