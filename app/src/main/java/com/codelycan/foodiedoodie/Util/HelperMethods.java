package com.codelycan.foodiedoodie.Util;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Base64;
import android.util.Log;

import java.io.ByteArrayOutputStream;

/**
 * Created by trushain on 4/17/16.
 */
public class HelperMethods {

    public static Bitmap getImageAsBitmap(String image){
        byte[] imageAsBytes = Base64.decode(image, Base64.DEFAULT);
        Bitmap bmp = BitmapFactory.decodeByteArray(imageAsBytes, 0, imageAsBytes.length);
        return bmp;
    }

    public static String getImageAsString(Bitmap bmp){
        ByteArrayOutputStream bYtE = new ByteArrayOutputStream();

        bmp.compress(Bitmap.CompressFormat.JPEG, 100, bYtE);
        byte[] byteArray = bYtE.toByteArray();
        String image= Base64.encodeToString(byteArray, Base64.DEFAULT);
        bmp.recycle();
        Log.d("Converted TO : ", image);
        return image;
    }
}
