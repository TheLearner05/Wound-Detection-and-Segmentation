from ultralytics import YOLO
import numpy as np
import torch
from pathlib import Path
model = YOLO(r"best.pt")
import cv2
import sys

  
def output(imgPath):
    
    img = cv2.imread(imgPath)
    img = cv2.resize(img,(640,640))
    results = model.predict(source=img.copy(), save=False, save_txt=False, stream=True, conf = 0.5)
    
    cnt = []
    for result in results:
        for i in result.masks.xy :

            cnt1 = []

            for j in i:
           
                x,y = int(j[0]),int(j[1])
                cnt1.append([x,y])

            cnt.append(np.array(cnt1))

    cnt = sorted(cnt, key=lambda c: cv2.boundingRect(c)[:2])
    gimg=cv2.drawContours(img,cnt,-1,(0,255,0),3,)
    file = open('output.txt', 'w')
    areas={}
    k=1
    for i in cnt:
        area = cv2.contourArea(i)
        #areas["contour"+str(k)] = area 
        file.write(f'"contour{k}":{area} ')
        gimg=cv2.putText(img,f"contour{k}: {area} pix",tuple(i[0]),cv2.FONT_HERSHEY_SIMPLEX,0.6,(255,0,0),2)
        k+=1

    
    cv2.imwrite(r'output_segs.jpg',gimg)

output(sys.argv[1])



